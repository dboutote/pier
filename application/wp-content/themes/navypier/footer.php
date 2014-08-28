<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */
?>

<footer>
  <div class="top">
    <div class="container clearfix">
      <div class="left-col">
        <h4 class="category">Quick Links</h4>
        <div class="quick-link clearfix"><a href="#"><img src="images/press-room-icon.png" class="footer-icon">
          <h4>Press Room</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum nibh at mauris vestibulum gravida.</p>
          </a> </div>
        <div class="quick-link clearfix"><a href="#"><img src="images/business-opportunities-icon.png" class="footer-icon">
          <h4>Business Opportunities</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum nibh at mauris vestibulum gravida.</p>
          </a> </div>
        <div class="quick-link clearfix"><a href="#"><img src="images/event-planning-icon.png" class="footer-icon">
          <h4>Event Planning</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum nibh at mauris vestibulum gravida.</p>
          </a> </div>
        <div class="quick-link clearfix"><a href="#"><img src="images/about-us-icon.png" class="footer-icon">
          <h4>About Us</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum nibh at mauris vestibulum gravida.</p>
          </a> </div>
        <div class="quick-link clearfix"><a href="#"><img src="images/support-us-icon.png" class="footer-icon">
          <h4>Support Us</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum nibh at mauris vestibulum gravida.</p>
          </a> </div>
      </div>
      <div class="right-col">
        <h4 class="category">Contact</h4>
        <div class="contact-info clearfix"> <a href="index.php"><img src="images/footer-logo-white.png" class="footer-logo"></a>
          <p><strong>Navy Pier</strong><br>
            600 E. Grand Avenue&nbsp;&nbsp;|&nbsp;&nbsp;Chicago, IL 60611<br>
            312 595-PIER 7437&nbsp;&nbsp;|&nbsp;&nbsp;800 595-PIER 7437</p>
        </div>
        <h4 class="category">Stay Connected</h4>
        <div class="social-links"><a href="https://twitter.com/navypier" target="_blank" class="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a><a href="https://www.facebook.com/navypier" target="_blank" class="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a><a href="http://www.youtube.com/user/NavyPierTV" target="_blank" class="tooltip" title="YouTube"><i class="fa fa-youtube"></i></a><a href="http://instagram.com/navypierchicago" target="_blank" class="tooltip" title="Instagram"><i class="fa fa-instagram"></i></a></div>
      </div>
      <div class="bottom-row">
        <h4 class="category">Our Partners</h4>
        <div class="sponsors"><img src="images/american-airlines-logo.png"><img src="images/landshark-logo.png"><img src="images/pepsi-logo.png"><img src="images/wgn-logo.png"></div>
      </div>
    </div>
  </div>
  <div class="bottom">
    <div class="container"><a href="index.php"><img src="images/footer-logo-black.png" class="footer-logo"></a>
      <div class="right-col">
        <nav>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Lost & Found</a></li>
            <li><a href="#">Code of Conduct</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </nav>
        <p class="copyright">Copyright &copy; 2011 Navy Pier, Inc., Chicago, IL. All Rights Reserved.</p>
      </div>
    </div>
  </div>
</footer>

	<?php wp_footer(); ?>
</body>
</html>