<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta
      name="description"
      content="Nakamuraのポートフォリオ。Web制作やデザインの実績、スキルセット、プロフィールをまとめています。"
    />
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico" id="favicon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Noto+Serif+JP:wght@200..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/vue.global.prod.js"></script>
    <script>
  window.themeUrl = "<?php echo get_stylesheet_directory_uri(); ?>";
</script>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.validate.min.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/messages_ja.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/form-validate.js"></script>
    <script>
      $(document).ready(function () {
        $("#contact_form").validate({
          errorPlacement: function (error, element) {
            if (window.matchMedia("(max-width: 768px)").matches) {
              var th = element.closest("td").prev("th");
              if (th.length) {
                error.insertAfter(th);
              } else {
                error.insertAfter(element);
              }
            } else {
              if (element.is(':radio')) {
                error.insertAfter(element.closest('.radio-group'));
              } else {
                error.insertAfter(element);
              }
            }
          },
        });
      });
    </script>
    <style>
      .error {
        color: red;
      }
    </style>
    <body>
      
    
    <div id="particles-js"></div>
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

    <header>
      <div class="header_wrap">
        <h1 id="headline"><a href="<?php echo home_url(); ?>">Nakamura</a></h1>
        <nav class="nav-pc" :class="{ open: navOpen }">
          <ul>
            <li id="header-home"><a href="<?php echo home_url(); ?>">Home</a></li>
            <li id="header-works"><a href="#works">Works</a></li>
            <li id="header-skill"><a href="#skill">Skill</a></li>
            <li id="header-about"><a href="#about">About</a></li>
            <li id="header-contact"><a href="#contact">Contact</a></li>
          </ul>
        </nav>
        <!-- ハンバーガー -->
        <div
          class="hamburger"
          :class="{ active: navOpen }"
          @click="navOpen = !navOpen"
        >
          <div></div>
          <div></div>
          <div></div>
        </div>
        <nav class="nav-sp" :class="{ open: navOpen }">
          <ul>
            <li><a href="https://www.nnzzm.com/portfolio_wp/" @click="navOpen = false">Home</a></li>
            <li><a href="#works" @click="navOpen = false">Works</a></li>
            <li><a href="#skill" @click="navOpen = false">Skill</a></li>
            <li><a href="#about" @click="navOpen = false">About</a></li>
            <li><a href="#contact" @click="navOpen = false">Contact</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <?php wp_head(); ?>
  </head>
  
    

