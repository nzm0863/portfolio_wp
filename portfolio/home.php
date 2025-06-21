<?php get_header(); ?>
<body>
<div id="app">
  <div class="hero">
  <h2>Portfolio</h2>
    <div class="video-container">
      <video
        playsinline
        autoplay
        loop
        muted
        preload="auto"
        :src="videoSources[currentVideoIndex]"
        :class="{ fade: isFading }"
      ></video>
    </div>
  </div>
  </div>

  <section class="works">
    <h2 class="works-headline" id="works">Works</h2>
    <ul class="works-items">
<?php
$works = new WP_Query(array('post_type' => 'works'));
if ($works->have_posts()) :
  while ($works->have_posts()) : $works->the_post();
    $title = get_field('work_name');
    $image = get_field('work_img');
    $description = get_field('work_description');
    $link = get_field('work_link');
?>
  <li class="works-item" id="works-item">
    <?php if ($image): ?>
      <?php if ($link): ?>
        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
        </a>
      <?php else: ?>
        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
      <?php endif; ?>
    <?php endif; ?>
    <h3><?php echo esc_html($title); ?></h3>
    <p><?php echo esc_html($description); ?></p>
  </li>
<?php
  endwhile;
  wp_reset_postdata();
endif;
?>
</ul>
  </section>

  <section class="skill">
    <h2 class="skill-headline" id="skill">Skill</h2>
    <ul class="skill-items">
<?php
$skills = new WP_Query(array('post_type' => 'skill'));
if ($skills->have_posts()) :
  while ($skills->have_posts()) : $skills->the_post();
    $name = get_field('skill_name');
    $image1 = get_field('skill_img1');
    $description = get_field('skill_description');
    $link = get_field('skill_link');
?>
  <li class="skill-item">
    <?php if ($image1 && is_array($image1)): ?>
      <?php if ($link): ?>
        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
          <img src="<?php echo esc_url($image1['url']); ?>" alt="">
        </a>
      <?php else: ?>
        <img src="<?php echo esc_url($image1['url']); ?>" alt="">
      <?php endif; ?>
    <?php endif; ?>
    <h3><?php echo esc_html($name); ?></h3>
    <p><?php echo esc_html($description); ?></p>
  </li>
<?php
  endwhile;
  wp_reset_postdata();
endif;
?>
    </ul>
  </section>

  <section class="about">
    <h2 class="about-headline" id="about">About</h2>
    <div class="about-items">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/me.jpg" alt="me" id="aboutImage" />
      <div class="about-caption" id="about-caption">
        Web制作を中心に、UI設計やフロントエンド開発を行っている静岡県浜松市在住の中村です。<br />
        HTML/CSSやJavaScript、Vue.jsなどを用いたコーディングを得意とし、FigmaやPhotoshopを使ったデザイン制作にも対応可能です。<br />「見る人に伝わる・使う人にとって心地よい」を大切に、丁寧なものづくりを心がけています。
      </div>
    </div>
  </section>

  <section class="contact" id="contact">
    <h1 class="contact-headline">Contact</h1>
    <div class="wrapper">
      <form
        action="<?php echo esc_url(home_url('/wp-content/themes/portfolio/page-confirm.php')); ?>"
        method="post"
        id="contact_form"
        class="h-adr"
      >
        <span class="p-country-name" style="display: none">Japan</span>
        <div class="sp100 of_x">
          <table id="contactform_table" class="width81 mb_30">
            <tbody>
            <tr>
              <th><label for="name">名前</label></th>
              <td>
                <input name="f_name" type="text" id="name" required />
              </td>
            </tr>
            <tr>
              <th><label for="email">メール</label></th>
              <td>
                <input
                  name="email"
                  type="email"
                  id="email"
                  size="45"
                  required
                />
              </td>
            </tr>

            <tr>
              <th><label for="tel">電話番号</label></th>
              <td>
                <input name="tel" type="tel" id="tel" required />
              </td>
            </tr>
            <tr>
              <th><label for="age">年齢</label></th>
              <td>
                <div class="select-group">
                  <select name="age" id="age">
                    <option value="" selected>-選択してください-</option>
                    <option value="10代">10代</option>
                    <option value="20代">20代</option>
                    <option value="30代">30代</option>
                    <option value="40代">40代</option>
                    <option value="50代">50代</option>
                    <option value="60代以上">60代以上</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <th>希望連絡方法</th>

              <td class="radio">
                <div class="radio-group">
                  <input
                    type="radio"
                    name="contact_means"
                    value="電話"
                    id="contact_tel"
                    required
                  /><label for="contact_tel">電話</label>
                  <input
                    type="radio"
                    name="contact_means"
                    value="メール"
                    id="contact_email"
                    required
                  /><label for="contact_email">メール</label>
                  <input
                    type="radio"
                    name="contact_means"
                    value="希望なし"
                    id="contact_others"
                    required
                  /><label for="contact_others">希望なし</label>
                </div>
              </td>
            </tr>
            <tr>
              <th><label for="comment">メッセージ</label></th>
              <td>
                <textarea
                  name="comment"
                  cols="70"
                  rows="10"
                  id="comment"
                  required
                ></textarea>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input
                  type="submit"
                  name="Submit"
                  value="確認"
                  id="submit"
                  class="form_btn"
                />
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </section>

  
    </div>
    
  
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/app.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/particles.js"></script>
<div id="particles-js"></div>
</div>


<?php get_footer(); ?>
