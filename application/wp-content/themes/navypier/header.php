<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js"></script>
<![endif]-->	
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header>
  <div class="top">
    <div class="container">
      <nav>
        <ul class="text-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Media &amp; PR</a></li>
          <li><a href="#">Sponsorship</a></li>
          <li><a href="#">Donate</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <ul class="social-links">
          <li><a href="https://twitter.com/navypier" target="_blank" class="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://www.facebook.com/navypier" target="_blank" class="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="http://www.youtube.com/user/NavyPierTV" target="_blank" class="tooltip" title="YouTube"><i class="fa fa-youtube"></i></a></li>
          <li><a href="http://instagram.com/navypierchicago" target="_blank" class="tooltip" title="Instagram"><i class="fa fa-instagram"></i></a></li>
          <li><a href="http://blog.navypier.com/" target="_blank" class="tooltip" title="Blog"><i class="fa fa-comments"></i></a></li>
        </ul>
        <ul class="quick-links">
          <li class="title">Quick Links:</li>
          <li><a href="#" class="tooltip" title="Calendar"><i class="fa fa-calendar"></i></a></li>
          <li><a href="#" class="tooltip" title="Buy Tickets"><i class="fa fa-ticket"></i></a></li>
        </ul>
      </nav>
      <div class="search tooltip" title="Search"><i class="fa fa-search"></i></div>
    </div>
  </div>
  <div class="search-row">
    <div class="container">
      <form role="search" method="get" action="#">
        <input type="text" name="s" id="s" placeholder="Search Navy Pier">
        <input type="submit" value="Submit">
      </form>
    </div>
  </div>
  <div class="middle">
    <div class="container">
      <div class="logo"><a href="index.php"><img src="images/logo.png"></a></div>
      <div class="menu-btn"><i class="fa fa-bars"></i></div>
      <nav class="main">
        <ul>
          <li id="mobile-map-btn" class="mobile-only"><a href="#">View Map</a></li>
          <li class="mobile-only"><a>Quick Links<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Information</li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Media &amp; PR</a></li>
                <li><a href="#">Sponsorship</a></li>
                <li><a href="#">Donate</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Book Your Event</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-comments"></i>&nbsp;&nbsp;&nbsp;Social Media</li>
                <li><a href="https://twitter.com/navypier" target="_blank">Twitter</a></li>
                <li><a href="https://www.facebook.com/navypier" target="_blank">Facebook</a></li>
                <li><a href="http://www.youtube.com/user/NavyPierTV" target="_blank">YouTube</a></li>
                <li><a href="http://instagram.com/navypierchicago" target="_blank">Instagram</a></li>
                <li><a href="http://blog.navypier.com/" target="_blank">Blog</a></li>
              </ul>
            </div>
          </li>
          <li><a>Redevelopment<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
                <li><a href="#">Drop Down Link 4</a></li>
                <li><a href="#">Drop Down Link 5</a></li>
                <li><a href="#">Drop Down Link 6</a></li>
                <li><a href="#">Drop Down Link 7</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;A Longer Title</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
                <li><a href="#">Drop Down Link 4</a></li>
              </ul>
            </div>
          </li>
          <li><a>Play<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-male"></i>&nbsp;&nbsp;&nbsp;By Land</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
                <li><a href="#">Drop Down Link 4</a></li>
                <li><a href="#">Drop Down Link 5</a></li>
                <li><a href="#">Drop Down Link 6</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-anchor"></i>&nbsp;&nbsp;&nbsp;By Lake</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
                <li><a href="#">Drop Down Link 4</a></li>
              </ul>
            </div>
          </li>
          <li><a>Eat<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-male"></i>&nbsp;&nbsp;&nbsp;By Land</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
                <li><a href="#">Drop Down Link 4</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-anchor"></i>&nbsp;&nbsp;&nbsp;By Lake</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
                <li><a href="#">Drop Down Link 4</a></li>
                <li><a href="#">Drop Down Link 5</a></li>
                <li><a href="#">Drop Down Link 6</a></li>
              </ul>
            </div>
          </li>
          <li><a>Calendar<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
              </ul>
            </div>
          </li>
          <li><a>Cruises<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
              </ul>
            </div>
          </li>
          <li><a>Visit<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-tag"></i>&nbsp;&nbsp;&nbsp;Category</li>
                <li><a href="#">Drop Down Link 1</a></li>
                <li><a href="#">Drop Down Link 2</a></li>
                <li><a href="#">Drop Down Link 3</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <div class="book-event"><a href="#">Book Your Event</a></div>
    </div>
  </div>
  <div class="bottom">
    <div class="container">
      <div class="join-newsletter">
        <div class="join-btn"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;Join our newsletter for deals and more<img src="images/menu-caret-black.png" class="caret"></div>
        <form method="POST" action="#">
          <input type="text" name="Email" placeholder="Enter Email Address" required>
          <input type="submit" name="Submit" value="Subscribe">
        </form>
      </div>
    </div>
  </div>
</header>
<div id="map-canvas"></div>
<div id="map-btn" title="Map"></div>
<div id="back-to-top-btn"><i class="fa fa-chevron-up"></i></div>