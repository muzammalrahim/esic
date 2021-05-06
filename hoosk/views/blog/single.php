<style>
.userlink {
	font-weight: bold;
	 }
.pubdate{
	 color: #777; 
	 }
.reply_message {
    margin-left: 100px;
}	  
  
</style>
 <div id="main-content" class="container blog">
   <div class="row">
        <?php   $totlal_comments = count($comments_data);?>
  
       <div class="col-md-8"> 
        <?php if($this->session->userdata('msg')){?>
                <div class="alert alert-success" id="mydiv">
                      <?php echo $this->session->userdata('msg');
                      $this->session->unset_userdata('msg');
                      ?>
		       </div>
        <?php }?>
        <?php if($this->session->userdata('errormsg')){?>
                <div class="alert alert-danger" id="mydiv">
                      <?php echo $this->session->userdata('errormsg');
                      $this->session->unset_userdata('errormsg');
                      ?>
		       </div>
        <?php }?>
        
            <?php if($blog_data){
              $blog_link  = $blog_data->slug;
			?>			  
            
            <h3 class="blog-title"> <a href="#" class="blog-title-link blog-link"><?= $blog_data->title ?> </a></h3>
            
            <p class="blog-date"> <span class="date-text"><?= $blog_data->date ?> </span> </p>
            
            <p class="blog-comments">
					<a  class="blog-link" id="comments" >  <?= $totlal_comments  ?>   Comments </a>
            </p>
          
           <div class="blog-separator">&nbsp;</div>
           
           <div class="blog-content">
				<div class="paragraph">
                
             <?= $blog_data->description; ?>

            </div>
     </div>
                 <div class="blog-separator">&nbsp;</div>
                 <p class="blog-date"> <span class="date-text">Published By: <?= $blog_data->author ?>  </span> </p>
                     <div class="blog-comments">
				         <a class="blog-link" id="comments"> <?= $totlal_comments  ?>   Comments </a>

	                  </div>
                <div id="commentsss"></div>       
                <div class="blog-post-separator"></div>
                <?php  }?>
                
           
           <!--Start comment Section  -->
                
          
           <?php if($comments_data){ ?>
            
           <div class="blog-content">
				<div class="paragraph">
                  <h1>  Comments </h1>  
                  
                   <?php 
				   
				     foreach($comments_data as $comments ){  
					 
					     ?>
                         <header><a   class="userlink"><?= $comments->name;?></a> - <span class="pubdate">Posted  <?= $comments->comment_date;?></span></header>
                         
					        <p class="comment">
                                      <?php echo   $comments->comment; ?>
                                      <h6 class="wsite-content-title" style="text-align:left; CURSOR: pointer;" id="<?= $comments->id ?>">
                                       <a> Leave a Reply. </a></h6>
                                        <div class="blog-post-separator"></div>
                            </p>
             <?php if($esic_comment_reply){  
                       foreach($esic_comment_reply as $replys){  
					        if($replys->comment_id == $comments->id){
 					     ?>
            <div class="reply_message"><header><a class="userlink"><?= $replys->name;?></a> - <span class="pubdate">Posted  <?= $replys->comment_date;?></span></header>
                          <p class="comment">
                                      <?php echo   $replys->comment; ?>
                                      <h6 class="wsite-content-title" style="text-align:left; CURSOR: pointer;" id="<?= $comments->id ?>">
                                       <a> Leave a Reply. </a></h6>
                                        </div><div class="blog-post-separator"></div>
                         </p>
                            
                
              <?php  }}?>
                
               
                  
             <?php   }?> 
               
                  
           
           <?php   }?> 
                  </div>   
                  </div>
                 <div  id="comments_f"></div>
              <?php  }?>
                  
           
           
            
          
           <!--End Comment Section  -->
           
                 
              
                
 </div>
       <div class="col-md-4">
                <h3 class="blog-title Latest-Blogs"> <a href="<?= base_url().'all-about-innovation'; ?>" class="blog-title-link blog-link"> Latest Blogs  </a> </h3>
                <ul class="blog-list side-bar-blog" id="style-4">
                 <?php  
				      if($blog_all_data){
			          foreach($blog_all_data as $blog_datas){


						  $link = $blog_datas->slug;

			           ?>
                    <li><a href="<?php echo  base_url().'all-about-innovation/'.$link ?>" class="blog-title-link blog-link" >
                          <?php echo  $blog_datas->title; ?>  </a>
                    </li>
                    <?php }} ?>
           
                </ul> 
             
            </div>
        
   </div>
   
   
   <h2 class="wsite-content-title" style="text-align:left;">Leave a Reply.<br></h2>
   <div class="col-lg-12" id="mainFormDiv">

   <form id="contact" action="<?php  echo base_url('blog/insert_comment')?>" method="post" enctype="multipart/form-data" data-url="">
         <div id="form1">
           <fieldset>
               <label for="Name">Name<span class="required-fields">*</span></label>
                    <div class="form-group">
                         <input id="Name" name="name" type="text" class="form-control" placeholder="Name" required="">
                    </div>



                    <div class="form-group">
                       <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="Email">Email (not published)<span class="required-fields">*</span></label>
                            <input id="Email" name="email" type="email" class="form-control" placeholder="xyz@example.com" required="">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                             <label for="Email">Website <span class="required-fields"></span></label>
                               <input id="Website" name="website" type="text" class="form-control" 
                         placeholder="https://www.esic.directory"  >
                            </div>
                        </div>
                    </div>
                   <label for="shortDescription">Comments <span class="required-fields">*</span></label>
                        <div class="form-group">
                        <input type="hidden" name="blog_title"  value="<?= $blog_data->title;?>"> 
                        <input type="hidden" name="blog_link"  value="<?= $blog_link;?>"> 
                        <input type="hidden" name="blog_id"    value="<?= $blog_data->id;?>">
                        <input type="hidden" name="comment_id"    value="" id="comment_id">
                      <textarea id="shortDescription" class="form-control" name="comment"><?php echo $clicked_id     ?>   </textarea>
                         </div>
                 </fieldset>

             <div class="row">
                 <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                     <div class="g-recaptcha" data-sitekey="6LeX-IgUAAAAABvHQ0LIZ-vhQ6Gw5uOMSnZL2MAv"></div>
                     <p id="emprecpcha" class="text-danger"></p>
                 </div>
             </div>
                 <div class="button-container">
                    <input type="submit" class="btn btn-primary btn-reply" value="Submit">
                </div>
             
        
    </div></form>
  </div>
 
</div>
<script>
// $(function () {
//  setTimeout(function() {
//                 $('#mydiv').fadeOut(5000);
//				 }, 2000);
//
// $("h6.wsite-content-title").click(function(){
//	    var id = $(this).attr("id");
//        $("#comment_id").val(id);
//    });
//$("h6.wsite-content-title").click(function() {
//    $('html,body').animate({
//        scrollTop: $("#comments_f").offset().top},
//        1000);
//});
//$("#comments").click(function() {
//    $('html,body').animate({
//        scrollTop: $("#commentsss").offset().top},
//        1000);
//});
//
//
//
// });
 </script>
<style>
    .g-recaptcha {
        width: 305px;
        margin-left: 20px;
    }
    .g-recaptcha iframe {
        height: 80px !important;
    }
    .side-bar-blog{
        max-height: 350px;
        overflow-y: scroll;

    }
    #style-4::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
    }

    #style-4::-webkit-scrollbar
    {
        width: 5px;
        background-color: #F5F5F5;
    }

    #style-4::-webkit-scrollbar-thumb
    {
        background-color: rgba(0, 0, 0, 0.12);
        border: 2px solid rgba(85, 85, 85, 0);
    }
    }

</style>