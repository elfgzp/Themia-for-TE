<?php
/**
 *<div style="color:rgb(9, 190, 245); font-weight:bold;">Te响应式主题 : Themia，一款个性化十分丰富，附加功能非常全面，自定义字段非常屌的华丽的响应式模板。<br>无需插件的文章置顶功能。<br>无需插件的图片灯箱效果。<br>无需插件的文章的浏览计数。<br>无需插件实现的缩略图功能。<br>集成的文章二维码功能，大赏功能，还有萌物kiana。</div>
 * 
 * @package <div id="blink">Themia</div><script language="javascript"> var i = 1;function changeColor(){ var color="#f00|#0f0|#00f|#880|#808|#088|yellow|green|blue|gray";color=color.split("|");document.getElementById("blink").style.color=color[parseInt(Math.random() * color.length)]; }setInterval("changeColor()",100); </script>
 * @author <font color=#FF0000>Jrotty</font>
 * @version <font color=#FF0000>3.6.0</font>
 * @link http://qqdie.com
 */
?>
  <?php $this->need('header.php'); ?>
 <header id="header" data-behavior="<?php $this->options->css(); ?>">
 <i id="btn-open-sidebar" class="fa fa-lg fa-bars"></i>
    <h1 class="header-title">
        <a class="header-title-link" href="<?php $this->options->siteUrl(); ?>" ><?php $this->options->title(); ?></a>
    </h1>
    
        
            <a  class="header-right-icon st-search-show-outputs"
                href="#about">
        
                <i class="fa fa-lg fa-search"></i>
            </a>
    
</header>

 <nav id="sidebar" data-behavior="<?php $this->options->css(); ?>">

<?php $this->need('sidebar.php'); ?>	  
<div id="main" data-behavior="<?php $this->options->css(); ?>"
                 class="
                        hasCoverMetaIn
                        ">            
            
<section class="postShorten-group main-content-wrap">
 
<?php /*
	if(is_home() && get_option('sticky_posts')){
    $sticky = get_option('sticky_posts'); 
    rsort( $sticky );//对数组逆向排序，即大ID在前 
    $sticky = array_slice( $sticky, 0, 3);//输出置顶文章数，请修改5，0不要动，如果需要全部置顶文章输出，可以把这句注释掉 
    query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1 ) ); 
    if (have_posts()) :while (have_posts()) : the_post();*/
?>
<?php if($this->_currentPage>1): ?><?php else: ?>
<?php if($this->is('index')): ?> 
<?php
$db = Typecho_Db::get();
$prefix = $db->getPrefix();
$sticky_posts = $db->fetchAll($this->db
	->select()->from($prefix.'contents')
	->orWhere('cid = ?',$this->options->sticky_1)
	->orWhere('cid = ?',$this->options->sticky_2)
	->orWhere('cid = ?',$this->options->sticky_3)
	->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish'));
	rsort( $sticky_posts );//对数组逆向排序，即大ID在前 
	foreach ($sticky_posts as $sticky_posts) {
		$result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($sticky_posts);
		$post_views = number_format($result['views']);
		$post_title = htmlspecialchars($result['title']);
		$post_date = date('M d,Y', $result['created']);
		$permalink = $result['permalink'];
		/*if($post_views > $this->options->view_num){echo 'HOT';} else {echo ''.$post_views.''' VIEW';};*/
		echo '<article class="postShorten" itemscope="" itemtype="http://schema.org/BlogPosting" id="article">   

                        
                     
      
            <div class="postShorten-wrap">
                <div class="postShorten-header">
                    <h1 class="postShorten-title" itemprop="headline">
                        
                               <span style="color:red">[置顶] </span> <a class="link-unstyled" href="'.$permalink.'">'.$post_title.'</a>
                        
                    </h1>
                
                </div>
                
            </div>
            
                  
          
                             
                
            
        </article>'."\n\r";}
?>
<?php endif; ?>

<?php
/*global $query_string;
  query_posts( $query_string . '&ignore_sticky_posts=1' );*/
?><?php endif; ?>

        <?php while($this->next()): ?>
        <?php if (!empty($this->options->sidebarBlock) && in_array('simg', $this->options->sidebarBlock)): ?>


     <article class="postShorten" itemscope itemType="http://schema.org/BlogPosting" id="article">  
<?php else: ?>
  <?php if (isset($this->fields->x)): ?>    
               <article class="postShorten" itemscope itemType="http://schema.org/BlogPosting" id="article">   

                       <?php else: ?><?php if (isset($this->fields->st)): ?>   <article class="postShorten" itemscope itemType="http://schema.org/BlogPosting" id="article">  <?php else: ?>
        <article class="postShorten postShorten--thumbnailimg" itemscope itemType="http://schema.org/BlogPosting" id="article">
              <?php endif; ?>  <?php endif; ?> 
                <?php endif; ?>     
      
            <div class="postShorten-wrap">
                <div class="postShorten-header">
                    <h1 class="postShorten-title" itemprop="headline">
                        
                                <a class="link-unstyled"  <?php if ($this->fields->l){ ?>href="<?php $this->fields->l(); ?>"  target="_blank"<?php }else{ ?>

href="<?php $this->permalink() ?>"<?php };?>><?php $this->title() ?></a>
                        
                    </h1>
                    <div class="postShorten-meta">
    <time itemprop="datePublished" content="<?php $this->date('Y-m-j  H:i'); ?>">
	
		     <?php $this->date('M d,Y'); ?>
    	
    </time>
    
      	  <span>in </span>
        
    <a class="category-link"><?php $this->category(',', true, '木有分类或者该分类已被删除'); ?></a>
<?php if ($this->options->jsq == '0'): ?><?php else: ?>
  <span>read (<?php if ($this->options->jsq == '1'): ?><?php get_post_view($this) ?><?php endif; ?><?php if ($this->options->jsq == '2'): ?><?php $this->viewsNum(); ?><?php endif; ?>)</span> 
<?php endif; ?>

<?php if($this->user->hasLogin()):?>
  <a href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php echo $this->cid;?>" class="category-link"  target="_blank">编辑</a>
<?php endif;?>
    
</div>
                </div>
                <div class="postShorten-excerpt" itemprop="articleBody">        <?php if (!empty($this->options->sidebarBlock) && in_array('simg', $this->options->sidebarBlock)): ?>
<?php else: ?>
                 <?php if (isset($this->fields->st)): ?>   <p><img src="<?php showThumbnail($this); ?>" alt=""></p> <?php endif; ?> <?php endif; ?> 
                        <p>
<?php if (isset($this->fields->d)): ?><?php $this->fields->d(); ?>...
<?php else: ?>
     <?php $this->excerpt(140, '...'); ?> 
                <?php endif; ?> 
</p>
                    
                    
                        
                            <a  <?php if ($this->fields->l){ ?>href="<?php $this->fields->l(); ?>"  target="_blank"<?php }else{ ?>

href="<?php $this->permalink() ?>"<?php };?> class="postShorten-excerpt_link link ">Continue reading</a>
                            
                        

                   
                </div>
            </div>
            
             <?php if (!empty($this->options->sidebarBlock) && in_array('simg', $this->options->sidebarBlock)): ?>
<?php else: ?>
 <?php if (isset($this->fields->st)): ?>  <?php else: ?>
<?php if (isset($this->fields->x)): ?>    
          
                       <?php else: ?>
     
          
                <div class="postShorten-thumbnailimg">
                    <img alt="" itemprop="image" src="<?php showThumbnail($this); ?> "/>
                </div>
                <?php endif; ?>    <?php endif; ?> <?php endif; ?> 
                
            
        </article>
    
        
            <?php endwhile; ?> 
        
        
    
        
             

     
           
    
        
        <div class="pagination-bar">

   <ul class="pagination">
        
        <li class="pagination-prev">
    <?php if ($this->options->cdl == '0'): ?>
            <?php $this->pageLink('<b class="btn btn--default btn--small">&nbsp;<i class="fa fa-angle-left text-base icon-mr"></i><span>Previous</span>&nbsp;  </b>','prev'); ?> 
<?php endif; ?><?php if ($this->options->cdl == '1'): ?> <?php $this->pageLink('<b class="btn btn--default btn--small">&nbsp;<i class="fa fa-angle-left text-base icon-mr"></i><span>上一页</span>&nbsp;  </b>','prev'); ?> <?php endif; ?>

                </li>
 
        <li class="pagination-next">        
  <?php if ($this->options->cdl == '0'): ?>
<?php $this->pageLink('<b class="btn btn--default btn--small">&nbsp;<span>Next</span><i class="fa fa-angle-right text-base icon-ml"></i>&nbsp;</b>','next'); ?>   <?php endif; ?> <?php if ($this->options->cdl == '1'): ?><?php $this->pageLink('<b class="btn btn--default btn--small">&nbsp;<span>下一页</span><i class="fa fa-angle-right text-base icon-ml"></i>&nbsp;</b>','next'); ?> <?php endif; ?>
        </li>
        
            
 <li class="pagination-number">

<?php if ($this->options->cdl == '0'): ?>page <?php endif; ?><?php if ($this->options->cdl == '1'): ?>第<?php endif; ?><?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?>


<?php if ($this->options->cdl == '0'): ?>  of <?php endif; ?><?php if ($this->options->cdl == '1'): ?>页/共<?php endif; ?><?php echo   ceil($this->getTotal() / $this->parameter->pageSize); ?><?php if ($this->options->cdl == '1'): ?>页<?php endif; ?>
</li>
    </ul>
</div>
 
</section>














	<?php $this->need('footer.php'); ?>