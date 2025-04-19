<?php
/*
Plugin Name: Meyil Rastgele Yorum
Description: Blog yazılarına rastgele, manuel veya Gemini API ile otomatik yorumlar ekleyin.
Version: 1.9.4
Author: <a href="https://meyil.net" target="_blank">meyiL</a>
*/

// Doğrudan erişimi engelle
defined('ABSPATH') || die('Direct access not allowed');

// Eklenti aktivasyonunda dosya kontrolü ve ayarlar
register_activation_hook(__FILE__, 'rastgele_yorum_ekle_aktivasyon');
function rastgele_yorum_ekle_aktivasyon() {
    $plugin_dir = plugin_dir_path(__FILE__);
    $files = ['ad.txt', 'soyad.txt', 'ip.txt', 'email.txt', 'site.txt'];
    foreach ($files as $file) {
        if (!file_exists($plugin_dir . $file)) {
            file_put_contents($plugin_dir . $file, '');
        }
    }
    add_option('gemini_api_key', '');
    // .htaccess dosyası oluştur
    $htaccess = $plugin_dir . '.htaccess';
    if (!file_exists($htaccess)) {
        file_put_contents($htaccess, "Deny from all\n");
    }
}

// Eklentiler sayfasında linkler
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'rastgele_yorum_ekle_ayarlar_link');
function rastgele_yorum_ekle_ayarlar_link($links) {
    $ayarlar_link = '<a href="' . admin_url('admin.php?page=rastgele-yorum-ekle') . '">Ayarlar</a>';
    $web_sitesi_link = '<a href="https://meyil.net" target="_blank">Web Sitesi</a>';
    array_push($links, $ayarlar_link, $web_sitesi_link);
    return $links;
}

// Admin menü
add_action('admin_menu', 'rastgele_yorum_ekle_menu');
function rastgele_yorum_ekle_menu() {
    if (current_user_can('manage_options') || current_user_can('edit_others_posts')) {
        add_menu_page('Rastgele Yorum Ekle', 'Rastgele Yorum', 'edit_others_posts', 'rastgele-yorum-ekle', 'rastgele_yorum_ekle_ayarlar', 'dashicons-admin-comments');
    }
}

// Select2 kütüphanesi
add_action('admin_enqueue_scripts', 'rastgele_yorum_ekle_scripts');
function rastgele_yorum_ekle_scripts($hook) {
    if ($hook !== 'toplevel_page_rastgele-yorum-ekle' || !(current_user_can('manage_options') || current_user_can('edit_others_posts'))) return;
    wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), null, true);
    wp_add_inline_script('select2', 'jQuery(document).ready(function($) { $("#yazi_secim_manual, #yazi_secim_gemini").select2({ placeholder: "Yazı seçin veya arayın", allowClear: true }); });');
}

// Gemini API ile yorum oluşturma
function gemini_yorum_olustur($post_id, $prompt, $api_key, $yorum_index) {
    $post = get_post($post_id);
    if (!$post) return false;

    $post_content = strip_tags($post->post_content);
    $variety_prompt = $yorum_index > 0 ? "Önceki yorumlardan farklı bir tarzda ve içerikte " : "";
    $full_prompt = "Makale: $post_content\n\nPrompt: $variety_prompt$prompt";

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . urlencode($api_key);
    $data = json_encode(array(
        "contents" => array(
            array(
                "parts" => array(
                    array("text" => $full_prompt)
                )
            )
        )
    ));

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log('Curl error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code !== 200) {
        error_log('Gemini API Response Code: ' . $http_code);
        curl_close($ch);
        return false;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    return $result['candidates'][0]['content']['parts'][0]['text'] ?? false;
}

// Ayarlar sayfası
function rastgele_yorum_ekle_ayarlar() {
    if (!(current_user_can('manage_options') || current_user_can('edit_others_posts'))) wp_die('Bu sayfaya erişim yetkiniz yok.');

    $plugin_dir = plugin_dir_path(__FILE__);
    $adlar = file($plugin_dir . 'ad.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $soyadlar = file($plugin_dir . 'soyad.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ipler = file($plugin_dir . 'ip.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $emailler = file($plugin_dir . 'email.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $siteler = file($plugin_dir . 'site.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Manuel yorum ekleme
    if (isset($_POST['yorum_ekle_manual']) && wp_verify_nonce($_POST['manuel_nonce'], 'manuel_yorum_ekle')) {
        $yazi_id = sanitize_text_field($_POST['yazi_secim_manual']);
        $yorum_icerik = sanitize_textarea_field($_POST['yorum_icerik']);
        $ad = sanitize_text_field($_POST['ad']);
        $soyad = sanitize_text_field($_POST['soyad']);
        $ip = sanitize_text_field($_POST['ip']);
        $email = sanitize_email($_POST['email']);
        $web_sitesi = sanitize_url($_POST['web_sitesi']);
        $web_sitesi_ekleme = isset($_POST['web_sitesi_ekleme']) ? 1 : 0;
        $direkt_yayinla = isset($_POST['direkt_yayinla']) ? 1 : 0;

        $kullanici_ad = empty($ad) && !empty($adlar) ? $adlar[array_rand($adlar)] : $ad;
        $kullanici_soyad = empty($soyad) && !empty($soyadlar) ? $soyadlar[array_rand($soyadlar)] : $soyad;
        $kullanici_ip = empty($ip) && !empty($ipler) ? $ipler[array_rand($ipler)] : $ip;
        $kullanici_email = empty($email) && !empty($emailler) ? $emailler[array_rand($emailler)] : $email;
        $kullanici_web_sitesi = !$web_sitesi_ekleme ? (empty($web_sitesi) && !empty($siteler) ? $siteler[array_rand($siteler)] : $web_sitesi) : '';

        $yorum_data = array(
            'comment_post_ID' => $yazi_id,
            'comment_author' => $kullanici_ad . ' ' . $kullanici_soyad,
            'comment_content' => $yorum_icerik,
            'comment_author_IP' => $kullanici_ip,
            'comment_author_email' => $kullanici_email,
            'comment_author_url' => $kullanici_web_sitesi,
            'comment_approved' => $direkt_yayinla,
            'comment_date' => current_time('mysql')
        );

        wp_insert_comment($yorum_data);
        echo '<div class="updated"><p>Manuel yorum başarıyla eklendi!</p></div>';
    }

    // Gemini ile otomatik yorum ekleme
    if (isset($_POST['yorum_ekle_gemini']) && wp_verify_nonce($_POST['gemini_nonce'], 'gemini_yorum_ekle')) {
        $yazi_id = sanitize_text_field($_POST['yazi_secim_gemini']);
        $gemini_prompt = sanitize_textarea_field($_POST['gemini_prompt']);
        $yorum_sayisi = min(intval($_POST['yorum_sayisi']), 3);
        $direkt_yayinla = isset($_POST['direkt_yayinla_gemini']) ? 1 : 0;
        $web_sitesi_ekleme = isset($_POST['web_sitesi_ekleme_gemini']) ? 1 : 0; // Yeni: Web sitesi ekleme kontrolü

        $api_key = get_option('gemini_api_key');
        if (!$api_key) {
            echo '<div class="error"><p>Gemini API anahtarı girilmemiş!</p></div>';
            return;
        }

        for ($i = 0; $i < $yorum_sayisi; $i++) {
            $yorum_icerik = gemini_yorum_olustur($yazi_id, $gemini_prompt, $api_key, $i);
            if (!$yorum_icerik) {
                echo '<div class="error"><p>Gemini API ile yorum oluşturulamadı. API anahtarını veya bağlantıyı kontrol edin.</p></div>';
                return;
            }

            $kullanici_ad = !empty($adlar) ? $adlar[array_rand($adlar)] : 'Anonim';
            $kullanici_soyad = !empty($soyadlar) ? $soyadlar[array_rand($soyadlar)] : 'Kullanıcı';
            $kullanici_ip = !empty($ipler) ? $ipler[array_rand($ipler)] : '127.0.0.1';
            $kullanici_email = !empty($emailler) ? $emailler[array_rand($emailler)] : 'anonim@example.com';
            $kullanici_web_sitesi = !$web_sitesi_ekleme ? (!empty($siteler) ? $siteler[array_rand($siteler)] : '') : ''; // Yeni: Web sitesi ekleme kontrolü

            $yorum_data = array(
                'comment_post_ID' => $yazi_id,
                'comment_author' => $kullanici_ad . ' ' . $kullanici_soyad,
                'comment_content' => $yorum_icerik,
                'comment_author_IP' => $kullanici_ip,
                'comment_author_email' => $kullanici_email,
                'comment_author_url' => $kullanici_web_sitesi,
                'comment_approved' => $direkt_yayinla,
                'comment_date' => current_time('mysql')
            );

            wp_insert_comment($yorum_data);
        }
        echo '<div class="updated"><p>' . $yorum_sayisi . ' adet otomatik yorum başarıyla eklendi!</p></div>';
    }

    // Gemini API anahtarı kaydetme
    if (isset($_POST['gemini_api_kaydet']) && wp_verify_nonce($_POST['api_nonce'], 'gemini_api_kaydet')) {
        update_option('gemini_api_key', sanitize_text_field($_POST['gemini_api_key']));
        echo '<div class="updated"><p>Gemini API anahtarı kaydedildi!</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Meyil Rastgele Yorum</h1>
        <p><strong>Nasıl Kullanılır?</strong> Solda manuel yorum ekleyebilir, sağda Gemini API ile otomatik yorumlar oluşturabilirsiniz. TXT dosyalarından rastgele veriler kullanılır. API anahtarınızı <a href="https://ai.google.dev" target="_blank">Google AI Studio</a>’dan alın.</p>

        <div style="display: flex; justify-content: space-between;">
            <!-- Manuel Yorum Ekleme (Sol Sütun) -->
            <div style="width: 48%;">
                <h2>Manuel Yorum Ekleme</h2>
                <form method="post" action="">
                    <?php wp_nonce_field('manuel_yorum_ekle', 'manuel_nonce'); ?>
                    <table class="form-table">
                        <tr>
                            <th><label for="yazi_secim_manual">Yorum Yapılacak Yazı</label></th>
                            <td>
                                <select name="yazi_secim_manual" id="yazi_secim_manual" style="width: 300px;">
                                    <option value=""><?php _e('Yazı seçin veya arayın', 'text-domain'); ?></option>
                                    <?php
                                    $yazilar = get_posts(array('numberposts' => -1, 'post_status' => 'publish'));
                                    foreach ($yazilar as $yazi) {
                                        echo '<option value="' . $yazi->ID . '">' . esc_html($yazi->post_title) . ' (ID: ' . $yazi->ID . ')</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="yorum_icerik">Yorum İçeriği</label></th>
                            <td><textarea name="yorum_icerik" id="yorum_icerik" rows="5" cols="50" placeholder="Yorumunuzu buraya yazın" required></textarea></td>
                        </tr>
                        <tr>
                            <th><label for="ad">Ad (Opsiyonel)</label></th>
                            <td><input type="text" name="ad" id="ad" class="regular-text" placeholder="Boş bırakılırsa rastgele seçilir"></td>
                        </tr>
                        <tr>
                            <th><label for="soyad">Soyad (Opsiyonel)</label></th>
                            <td><input type="text" name="soyad" id="soyad" class="regular-text" placeholder="Boş bırakılırsa rastgele seçilir"></td>
                        </tr>
                        <tr>
                            <th><label for="ip">IP Adresi (Opsiyonel)</label></th>
                            <td><input type="text" name="ip" id="ip" class="regular-text" placeholder="Boş bırakılırsa rastgele seçilir"></td>
                        </tr>
                        <tr>
                            <th><label for="email">E-posta (Opsiyonel)</label></th>
                            <td><input type="email" name="email" id="email" class="regular-text" placeholder="Boş bırakılırsa rastgele seçilir"></td>
                        </tr>
                        <tr>
                            <th><label for="web_sitesi">Web Sitesi (Opsiyonel)</label></th>
                            <td><input type="url" name="web_sitesi" id="web_sitesi" class="regular-text" placeholder="Boş bırakılırsa rastgele seçilir"></td>
                        </tr>
                        <tr>
                            <th><label for="web_sitesi_ekleme">Web Sitesi Ekleme</label></th>
                            <td>
                                <input type="checkbox" name="web_sitesi_ekleme" id="web_sitesi_ekleme" value="1">
                                <label for="web_sitesi_ekleme">Web sitesi ekleme (işaretlenirse kullanılmaz)</label>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="direkt_yayinla">Yayın Durumu</label></th>
                            <td>
                                <input type="checkbox" name="direkt_yayinla" id="direkt_yayinla" value="1">
                                <label for="direkt_yayinla">Yorumu Direkt Yayınla</label>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button('Yorum Ekle', 'primary', 'yorum_ekle_manual'); ?>
                </form>
            </div>

            <!-- Gemini ile Otomatik Yorum (Sağ Sütun) -->
            <div style="width: 48%;">
                <h2>Gemini ile Otomatik Yorum</h2>
                <form method="post" action="">
                    <h3>Gemini API Ayarları</h3>
                    <?php wp_nonce_field('gemini_api_kaydet', 'api_nonce'); ?>
                    <table class="form-table">
                        <tr>
                            <th><label for="gemini_api_key">Gemini API Anahtarı</label></th>
                            <td><input type="password" name="gemini_api_key" id="gemini_api_key" class="regular-text" value="<?php echo esc_attr(get_option('gemini_api_key')); ?>" placeholder="Gemini API anahtarınızı buraya girin"></td>
                        </tr>
                    </table>
                    <?php submit_button('API Anahtarını Kaydet', 'secondary', 'gemini_api_kaydet'); ?>
                </form>

                <form method="post" action="">
                    <?php wp_nonce_field('gemini_yorum_ekle', 'gemini_nonce'); ?>
                    <table class="form-table">
                        <tr>
                            <th><label for="yazi_secim_gemini">Yorum Yapılacak Yazı</label></th>
                            <td>
                                <select name="yazi_secim_gemini" id="yazi_secim_gemini" style="width: 300px;">
                                    <option value=""><?php _e('Yazı seçin veya arayın', 'text-domain'); ?></option>
                                    <?php
                                    foreach ($yazilar as $yazi) {
                                        echo '<option value="' . $yazi->ID . '">' . esc_html($yazi->post_title) . ' (ID: ' . $yazi->ID . ')</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="gemini_prompt">Gemini Prompt</label></th>
                            <td><textarea name="gemini_prompt" id="gemini_prompt" rows="3" cols="50" placeholder="Örnek: 'Bu makaleye olumlu bir yorum yaz'" required></textarea></td>
                        </tr>
                        <tr>
                            <th><label for="yorum_sayisi">Yorum Sayısı</label></th>
                            <td>
                                <select name="yorum_sayisi" id="yorum_sayisi">
                                    <?php for ($i = 1; $i <= 3; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="web_sitesi_ekleme_gemini">Web Sitesi Ekleme</label></th>
                            <td>
                                <input type="checkbox" name="web_sitesi_ekleme_gemini" id="web_sitesi_ekleme_gemini" value="1">
                                <label for="web_sitesi_ekleme_gemini">Web sitesi ekleme (işaretlenirse kullanılmaz)</label>
                            </td>
                        </tr> <!-- Yeni: Web sitesi ekleme onay kutusu -->
                        <tr>
                            <th><label for="direkt_yayinla_gemini">Yayın Durumu</label></th>
                            <td>
                                <input type="checkbox" name="direkt_yayinla_gemini" id="direkt_yayinla_gemini" value="1">
                                <label for="direkt_yayinla_gemini">Yorumları Direkt Yayınla</label>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button('Otomatik Yorum Ekle', 'primary', 'yorum_ekle_gemini'); ?>
                </form>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            Geliştirici: <a href="https://meyil.net" target="_blank">meyiL</a>
        </div>
    </div>
    <?php
}

// Stil
add_action('admin_head', 'rastgele_yorum_ekle_stil');
function rastgele_yorum_ekle_stil() {
    if (!(current_user_can('manage_options') || current_user_can('edit_others_posts'))) return;
    echo '<style>.form-table th { width: 150px; } .regular-text { width: 25em; } .select2-container { width: 300px !important; }</style>';
}