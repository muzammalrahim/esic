<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feeds extends MY_Controller {
	function __construct(){ 
		parent::__construct();
	}
  	public function index(){
        // creating rss feed with our most recent 20 posts in variable $post
        //Currentl number 20 not working
      	$posts = getBlogs($this, 20);

        // first load the library
        $this->load->library('feed');

        // create new instance
        $feed = new Feed();

        // set your feed's title, description, link, pubdate and language
        $feed->title = 'Esic Directory';
        $feed->description = 'ESIC Directory is an advisory, assessment and listing service for Australian start-ups, angel investors, advisers, R and D partners, universities and accelerators. Learn about what it takes to be considered an early stage innovation company, the tax concessions available, thresholds and enjoy the apple resources available. Search for vetted ESIC companies, eligible accelerator/grant/university and other programs as well as checklists, databases and more. Complete our online company and investor pre-assessments, ask for help, join our mailing list or find an adviser. Just quietly its a great place to connect.';
        $feed->link = base_url().'feed';
        $feed->lang = 'en';
         // date of your last update (in this example create date of your latest post)

        $pubdate = '';
        // add posts to the feed

        foreach ($posts as $post){
        	
            $slug = getBlogSlug($post->id,$post->title);
            $pubdate = $post->date;
    	  	
            // set item's title, author, url, pubdate and description
            $feed->add($post->title, $post->author, $slug, $post->date, $post->description,$post->description);
        }
        // show your feed (options: 'atom' (recommended) or 'rss')
        $feed->pubdate = $pubdate;
        //$feed->render('atom');
        $feed->render('rss');
    }
    public function atom(){
        // creating rss feed with our most recent 20 posts in variable $post
        //Currentl number 20 not working
        $posts = getBlogs($this, 20);

        // first load the library
        $this->load->library('feed');

        // create new instance
        $feed = new Feed();

        // set your feed's title, description, link, pubdate and language
        $feed->title = 'Esic Directory';
        $feed->description = 'ESIC Directory is an advisory, assessment and listing service for Australian start-ups, angel investors, advisers, R and D partners, universities and accelerators. Learn about what it takes to be considered an early stage innovation company, the tax concessions available, thresholds and enjoy the apple resources available. Search for vetted ESIC companies, eligible accelerator/grant/university and other programs as well as checklists, databases and more. Complete our online company and investor pre-assessments, ask for help, join our mailing list or find an adviser. Just quietly its a great place to connect.';
        $feed->link = base_url().'feed/atom';
        $feed->lang = 'en';
         // date of your last update (in this example create date of your latest post)

        $pubdate = '';
        // add posts to the feed

        foreach ($posts as $post){
            
            $slug = getBlogSlug($post->id,$post->title);
            $pubdate = $post->date;
            
            // set item's title, author, url, pubdate and description
            $feed->add($post->title, $post->author, $slug, $post->date, $post->description,$post->description);
        }
        // show your feed (options: 'atom' (recommended) or 'rss')
        $feed->pubdate = $pubdate;
        $feed->render('atom');
        //$feed->render('rss');
    }
}		    