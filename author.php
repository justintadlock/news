<?php get_header(); ?>
		<div id="content">	
        <?php include_once(TEMPLATEPATH . '/topbanner.php'); ?>	

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>



			<!-- This sets the $curauth variable -->
			<?php
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
			?>


			<h1><?php echo $curauth->display_name; ?></h1>
                        <table>
                          <tr>
                            <th>Website</th>
                            <td>
                              <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a>
                            </td>
                          </tr>
                          <tr>
                            <th>Profile</th>
                            <td>
                              <?php echo $curauth->user_description; ?>
                            </td>
                          </tr>
			<!-- Google+ -->
                        <?php if($curauth->google_profile<>'') {?>
                          <tr>
                            <th>Google+</th>
                            <td>
                              <a href="<? echo $curauth->google_profile;?>" rel="me">Google Profile</a>
                            </td>
                          </tr>
                        <?}?>
			<!-- Twitter -->
                        <?php if($curauth->twitter_profile<>'') {?>
                          <tr>
                            <th>Twitter</th>
                            <td>
                              <a href="<? echo $curauth->twitter_profile;?>" rel="me">Twitter Profile</a>
                            </td>
                          </tr>
                        <?}?>
                        </table>

			<h2>Posts by <?php echo $curauth->display_name; ?>:</h2>
			<ul>
			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
			<?php the_title(); ?></a>
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.'); ?></p>
			<?php endif; ?>
			<!-- End Loop -->
			</ul>


		</div>
	</div>

    <?php get_sidebar(); ?>
<?php get_footer(); ?>
