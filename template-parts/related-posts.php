<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>

 <div class="ds8-rp-container"><h3><?php echo $title ?></h3>
    <div class="ds8-related-posts" id="ds8-related-posts">
      <?php
          if( ! empty( $my_posts ) ):
                foreach ( $my_posts as $p ){
          ?>
          <div class="slide">
              <div>
              <a href="<?php echo get_permalink($p->ID); ?>" class="ds8related post-thumbnail">
                <?php echo get_the_post_thumbnail($p->ID) ?>
              </a>
              </div>
              <div>
              <a href="<?php echo get_permalink($p->ID); ?>" class="ds8related post-title-related">
                <?php echo mb_strimwidth( get_the_title($p->ID), 0, 50, '...' ); ?>
              </a>
              <div class="ds8related">
              <?php
                $args = array(
			'show_published' => true,
			'show_modified'  => false,
			'modified_label' => '',
			'date_format'    => '',
			'before'         => '<span class="posted-on">',
			'after'          => '</span>',
		);
                $time_string = '<time class="entry-date updated" datetime="%4$s"%5$s>%6$s</time>';
                
                $args['modified_label'] = $args['modified_label'] ? $args['modified_label'] . ' ' : '';
                $time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			'itemprop="datePublished"',
			esc_html( get_the_date( $args['date_format'] ) ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			'itemprop="dateModified"',
			esc_html( $args['modified_label'] ) . esc_html( get_the_modified_date( $args['date_format'] ) )
		);
                echo sprintf(
                          '%1$s%2$s%3$s',
                          $args['before'],
                          $time_string,
                          $args['after']
                );
              ?>  
              </div>
            </div>
          </div>	
          <?php	
                  }
          endif;
          ?>
  </div>
</div>
