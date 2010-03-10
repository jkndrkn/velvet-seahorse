<?php
  $p = $_GET['p'];
?>
<br />
<div class="menu">
<span class="menu">
<a style="<?php echo ($p == 'main') ? "font-weight: bold" : ''?>" 
  class="head" href="?p=main">NEWS</a><br />
<a style="<?php echo ($p == 'shop') ? "font-weight: bold" : ''?>" 
  class="head" href="?p=shop">SHOP</a>&nbsp;&nbsp;<br />
</span>
   <div class="subhead">
   <a style="<?php echo ($p == 'photos') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=photos">Photos</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
   <a style="<?php echo ($p == 'jewelry') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=jewelry">Jewelry</a>&nbsp;&nbsp;<br />
   <a style="<?php echo ($p == 'ceramics') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=ceramics">Ceramics</a>&nbsp;&nbsp;<br />
   <a style="<?php echo ($p == 'mixed_media') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=mixed_media">Mixed Media</a><br />
   </div>
<span class="menu">
<a style="<?php echo ($p == 'about') ? "font-weight: bold" : ''?>" 
  class="head" href="?p=about">ABOUT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br />
</span>
   <div class="subhead">
   <a style="<?php echo ($p == 'contact') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=contact">Contact</a>&nbsp;&nbsp;&nbsp;&nbsp;<br />
   <a style="<?php echo ($p == 'links') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=links">Links</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
   <a style="<?php echo ($p == 'resume') ? "font-weight: bold" : ''?>" 
      class="subhead" href="?p=resume">Resume</a><br />
   </div>
<span class="menu">
<a style="<?php echo ($p == 'faq') ? "font-weight: bold" : ''?>" 
  class="head" href="?p=faq">FAQ</a><br />
</span>
</div>
<br />
