    <div class="footer_box_cont">
    
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer First Box') ) : ?>           
      
      <div class="footer_box">
        <h3>SOCIAL</h3>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Tumblr</a></li>
          <li><a href="#">Dribbble</a></li>
          <li><a href="#">Forrst</a></li>
        </ul>
      </div><!--//footer_box-->
      
      <?php endif; ?>
      
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Second Box') ) : ?>           
      
      <div class="footer_box">
        <h3>PORTFOLIO</h3>
        <ul>
          <li><a href="#">Use Widget Setup</a></li>
          <li><a href="#">Sample Portfolio</a></li>
          <li><a href="#">Business card</a></li>
          <li><a href="#">Flyer design</a></li>
          <li><a href="#">Banner re-design</a></li>
        </ul>
      </div><!--//footer_box-->      
      
      <?php endif; ?>
      
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Third Box') ) : ?>           
      
      <div class="footer_box">
        <h3>BLOG</h3>
        <ul>
          <li><a href="#">Use Widget Setup</a></li>
          <li><a href="#">Illustration for brochure</a></li>
          <li><a href="#">Business card</a></li>
          <li><a href="#">Flyer design</a></li>
          <li><a href="#">Banner re-design</a></li>
        </ul>
      </div><!--//footer_box-->            
      
      <?php endif; ?>
      
      <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Fourth Box') ) : ?>           
      
      <div class="footer_box footer_box_last">
        <h3>CONTACT</h3>
        <ul>
          <li>Marios Lublinski</li>
          <li>Tel: 1-800-232-0000</li>
          <li>Fax: 1-800-232-0001</li>
          <li>Marios@dessign.net</li>
        </ul>
      </div><!--//footer_box-->                  
      
      <?php endif; ?>
      
      <div class="clear"></div>
      
    </div><!--//footer_box_cont-->
    
  </div><!--//main_container-->
  
  <div id="footer"> Copyright 2012. All Rights Reserved. Design & Developed by <a href="http://www.dessign.net">Dessign.net</a> 
  
</div><!--//outside_container-->

<?php wp_footer(); ?>
</body>
</html>