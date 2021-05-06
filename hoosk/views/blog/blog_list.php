<div id="main-content" class="container blog all-about">
   <div class="row">

       <div class="col-md-4 blog_side_bar">
           <h3 class="blog-title Latest-Blogs"> <a href="<?= base_url().'all-about-innovation'; ?>" class="blog-title-link blog-link"> Latest Blogs  </a> </h3>
           <ul class="blog-list side-bar-blog" id="style-4">
               <?php
               if($blog_list){
                   foreach($blog_list as $blog_lists){
                     //  $links = str_replace(" ","_",$blog_lists->title);
                       $links = $blog_lists->slug;
                       $id    = $blog_lists->id;
                       ?>
                       <li><a href="<?php echo  base_url().'all-about-innovation/'.$links ?>" class="blog-title-link blog-link" >
                               <?=  $blog_lists->title; ?>  </a>
                       </li>
                   <?php }} ?>
             </ul>

       </div>
       <div class="col-md-8">
           <h1> All about innovation</h1>
              
            <?php      
			 		 if($blog_data){
			         foreach($blog_data as $blog){
					    $link          = $blog->slug;
						$id            = $blog->id;
						$totla_comment = $this->Common_model->get_comments_data('esic_comment',$id);
					    $totla_comment = count ($totla_comment);
						 
			?> 
            
            <h3 class="blog-title"> <a href="<?php echo  base_url().'all-about-innovation/'.$link ?>" class="blog-title-link blog-link"><?= $blog->title;?> </a></h3>
            
            <p class="blog-date"> <span class="date-text"> <?= $blog->date;?></span> </p>
            
            <p class="blog-comments">
					<a href="<?= base_url().'blog/'.$id."/".$link?>#commentsss"
                     class="blog-link"> <?= $totla_comment; ?> Comments </a> 
            </p>
          
           <div class="blog-separator">&nbsp;</div>
           
           <div class="blog-content">
				<div class="paragraph">
                
              <?= $blog->description;?>

            </div>
     </div>
                 <div class="blog-separator">&nbsp;</div>
                 <p class="blog-date"> <span class="date-text">Published By: <?= $blog->author;?>  </span> </p>
                     <div class="blog-comments">
				         <a href="<?= base_url().'blog/'.$id."/".$link?>#commentsss"
                     class="blog-link"> <?= $totla_comment; ?> Comments </a> 

	                  </div>
                <div class="blog-post-separator"></div>
         <?php }} ?> 
         
         
         <nav aria-label="Page navigation">
          <?php echo $this->pagination->create_links(); ?>
          </nav> 
         
         
               
 </div>

        
   </div>

</div>

 
