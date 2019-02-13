<?php


/**
 * Get article schemal.
 *
 * @param string $schema Article type.
 * @return void
 */
function mynote_article_schemal( $schema = 'Article' ) {
	switch ( $schema ) {
		case 'tech':
			$schema = 'TechArticle';
			break;
		case 'news':
			$schema = 'NewsArticle';
			break;
		case 'scholarly':
			$schema = 'ScholarlyArticles';
			break;
		default:
			$schema = 'Article';
	}
	echo 'http://schema.org/' . $schema;
}

/**
 * Mynote navigation.
 *
 * @param string $position The position on a page.
 */
function mynote_nav( $position = 'header' ) {
	if ( 'header' === $position ) {

		// This class will be loaded if an user installed Mynote MD plugin.
		// https://github.com/terrylinooo/mynote-md
		if ( class_exists( 'Githuber_Walker' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'header-menu',
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'mynote-nav-bar',
					'menu_class'      => 'navbar-nav mr-auto',
					'menu_id'         => false,
					'depth'           => 2,
					'fallback_cb'     => 'Githuber_Walker::fallback',
					'walker'          => new Githuber_Walker(),
				)
			);
		} else {
			wp_nav_menu(
				array(
					'theme_location'  => 'header-menu',
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'mynote-nav-bar',
					'menu_class'      => 'navbar-nav mr-auto',
					'menu_id'         => false,
					'depth'           => 1
				)
			);
		}
	}

	if ( 'footer' === $position ) {
		if ( has_nav_menu( 'footer-menu' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'footer-menu',
					'container'       => 'nav',
					'container_class' => 'footer-nav',
					'container_id'    => 'mynote-footer-nav',
					'menu_class'      => 'footer-menu',
					'menu_id'         => false,
					'depth'           => 1,
				)
			);
		}
	}
}

/**
 * If header_menu not set.
 */
function mynote_default_nav() {
	?>
	<div id="mynote-nav-bar" class="collapse navbar-collapse">
		<ul id="menu-primary-menu" class="navbar-nav mr-auto">
			<li class="nav-item"><a href="<?php get_home_url(); ?>" class="nav-link"><?php esc_html_e( 'Home', 'mynote' ); ?></a></li>
		</ul>
	</div>
	<?php
}

/**
 * The mynote Post thumbnail.
 */
function mynote_post_thumbnail() {
	the_post_thumbnail( '360x240',
		array(
			'class' => 'card-img-top',
			'alt'   => get_the_title(),
		)
	);
}

/**
 * Mynote - Bootstrap 4 Pagination
 *
 * @param integer $range - range of pagination to show previous and next pages.
 * @return void
 */
function mynote_pagination( $range = 1 ) {
	global $paged, $wp_query;

	$current    = $paged;
	$pages      = $wp_query->max_num_pages;
	// $pagi_items = ( $range * 2 ) + 1;
	$pagi_items = $range;

	if ( empty( $pages ) ) {
		$pages = $wp_query->max_num_pages;

		if ( empty( $pages ) ) {
			$pages = 1;
		}
	}

	if ( 0 === $current ) {
		$current = 1;
	}

	if ( 1 !== $pages ) {
		?>

		<nav aria-label="Page navigation" role="navigation">
			<span class="sr-only"><?php esc_html_e( 'Page navigation', 'mynote' ); ?></span>
			<ul class="pagination justify-content-center ft-wpbs">

				<li class="page-item disabled hidden-md-down d-none d-lg-block">
					<span class="page-link"><?php echo esc_html( $current ); ?> / <?php echo esc_html( $pages ); ?></span>
				</li>

				<?php if ( $current > 2 && $current > $range + 1 && $pagi_items < $pages ) : ?>

				<li class="page-item">
					<a class="page-link" href="<?php echo esc_url( get_pagenum_link( 1 ) ); ?>" aria-label="<?php esc_attr_e( 'First Page', 'mynote' ); ?>">
						&laquo;<span class="hidden-sm-down d-none d-md-inline-block">&nbsp;<?php esc_html_e( 'First', 'mynote' ); ?></span>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( $current > 1 && $pagi_items < $pages ) : ?>
					<li class="page-item">
						<a class="page-link" href="<?php echo esc_url( get_pagenum_link( $current - 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Previous Page', 'mynote' ); ?>">
							&lsaquo;<span class="hidden-sm-down d-none d-md-inline-block">&nbsp;<?php esc_html_e( 'Previous', 'mynote' ); ?></span>
						</a>
					</li>
				<?php endif; ?>

				<?php for ( $i = 1; $i <= $pages; $i++ ) : ?>
					<?php if ( 1 !== $pages && ( ! ( $i >= $current + $range + 1 || $i <= ( $current - $range ) - 1 ) || $pages <= $pagi_items ) ) : ?>
						<?php if ( $current === $i ) : ?>
							<li class="page-item active">
								<span class="page-link">
									<span class="sr-only"><?php esc_html_e( 'Current Page', 'mynote' ); ?></span>
									<?php echo esc_html( $i ); ?>
								</span>
							</li>
						<?php else : ?>
							<li class="page-item">
								<a class="page-link" href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>">
									<span class="sr-only"><?php esc_html_e( 'Page', 'mynote' ); ?></span>
									<?php echo esc_html( $i ); ?>
								</a>
							</li>
						<?php endif; ?>
					<?php endif; ?>
				<?php endfor; ?>

				<?php if ( $current < $pages && $pagi_items < $pages ) : ?>
					<li class="page-item">
						<a class="page-link" href="<?php echo esc_url( get_pagenum_link( $current + 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Next Page', 'mynote' ); ?>">
							<span class="hidden-sm-down d-none d-md-inline-block"><?php esc_html_e( 'Next', 'mynote' ); ?>&nbsp;</span>&rsaquo;
						</a>
					</li>
				<?php endif; ?>

				<?php if ( $current < $pages - 1 && $current + $range - 1 < $pages && $pagi_items < $pages ) : ?>
					<li class="page-item">
						<a class="page-link" href="<?php echo esc_url( get_pagenum_link( $pages ) ); ?>" aria-label="<?php esc_attr_e( 'Last Page', 'mynote' ); ?>">
							<span class="hidden-sm-down d-none d-md-inline-block"><?php esc_html_e( 'Last', 'mynote' ); ?>&nbsp;</span>&raquo;
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>

		<?php
	}
}

/**
 * Get the excerpt.
 *
 * @return void
 */
function mynote_excerpt() {
	global $post;

	$output = get_the_excerpt();
	$output = apply_filters( 'wptexturize', $output );
	$output = apply_filters( 'convert_chars', $output );
	echo $output;
}

/**
 * Is text fade out or not. (post list)
 *
 * @return bool
 */
function mynote_is_text_fade_out() {
	return true;
}


/**
 * Show title progress bar.
 *
 * @return void
 */
function mynote_title_progress_bar() {
	?>
		<div class="single-post-title-bar clear" role="banner">
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-dark" role="navigation">
					<a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>"></a>
					<div id="progress-title"></div>
				</nav>
			</div>
			<div class="progress-wrapper">
				<div class="progress-label"></div>
				<progress></progress>
			</div>
		</div>
	<?php
}

/**
 * Custom edit button with GitHub style.
 *
 * @return void
 */
function mynote_edit_button() {
	global $post;

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	echo '
		<a href="' . esc_url( get_edit_post_link() ) . '" class="button-like-link">
			<div class="btn-counter text-only">		
				<div class="btn">' . esc_html__( 'Edit', 'mynote' ) . '</div>
			</div>
		</a>
	';
}

/**
 * Adjust columns.
 *
 * @return void
 */
function mynote_column_control_button() {
	?>
		<div class="btn-group column-control">
			<div class="btn-counter text-only active" data-target="#aside-container" role="button">		
				<div class="btn"><i class="fas fa-columns"></i></div>
			</div>
			<div class="btn-counter text-only" data-target="#sidebar" role="button">		
				<div class="btn"><i class="fas fa-list-ul"></i></div>
			</div> 
		</div>
	<?php
}

/**
 * The comment button.
 *
 * @param bool $show_label Display label.
 * @return void
 */
function mynote_comment_button( $show_label = false ) {
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
		return;
	}

	echo '
		<a href="' . esc_url( get_the_permalink() ) . '#comments" class="button-like-link">
			<div class="btn-counter">
				<div class="btn">
					' . ( ( $show_label ) ? '<i class="fas fa-comment-dots"></i> ' . esc_html__( 'Comment', 'mynote' ) : '<i class="fas fa-comment-dots"></i>' ) . '
				</div>
				<div class="count-box">' . esc_html( get_comments_number() ) . '</div>
			</div>
		</a>
	';
}

/**
 * The Mynote button.
 *
 * @return void
 */
function mynote_read_button() {
	echo '
		<a href="' . esc_url( get_the_permalink() ) . '" class="button-like-link">
			<div class="btn-counter text-only">		
				<div class="btn">' . esc_html__( 'Read', 'mynote' ) . '</div>
			</div>
		</a>
	';
}

/**
 * Post figure.
 *
 * @return void
 */
function mynote_post_figure() {
	$thumbnail_caption = get_the_post_thumbnail_caption();
	?>
		<figure>
			<?php
				the_post_thumbnail( '', array(
					'itemprop' => 'image',
					'alt'      => esc_attr( $thumbnail_caption ),
				) );
			?>
			<figcaption><?php echo esc_html( $thumbnail_caption ); ?></figcaption>
		</figure>
	<?php
}

/**
 * The posted date button.
 *
 * @param bool $show_label Show text label or not.
 * @return void
 */
function mynote_posted_date_button( $show_label = false ) {
	echo '
		<div class="btn-counter">
			<div class="btn">
				<i class="far fa-calendar-alt"></i> ' . ( ( $show_label ) ? esc_html__( 'Date', 'mynote' ) : '' ) . '
			</div>
			<div class="count-box">' . date( 'Y-m-d', get_the_time( 'U' ) ) . '</div>
		</div>
	';
}

/**
 * The authour posted date.
 *
 * @param bool $show_avatar Show author avatar.
 * @param int  $avatar_size Avatar size.
 * @return void
 */
function mynote_author_posted_date( $show_avatar = false, $avatar_size = 40 ) {
	echo '<div class="author-posted-date">';

	if ( $show_avatar ) {
		echo '<img src="' . esc_url( get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => $avatar_size ) ) ) . '" class="rounded-circle poster-avatar" align="middle"> ';
	}
	printf( '<a href="%1$s" title="written %2$s" class="author-link">%3$s</a> <time itemprop="datePublished" datetime="%4$s">%5$s</time>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_html__( '%1$s @ %2$s', 'mynote' ),
			esc_html( get_the_date() ), 
			esc_attr( get_the_time() )
		),
		get_the_author(),
		get_the_time( 'c' ),
		sprintf( 
			_x( 'written %s ago', '%s', 'mynote' ),
			human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
		)
	);

	echo '</div>';
}

/**
 * Site icon.
 *
 * @return string Icon Url
 */
function mynote_site_icon() {
	$fallback_url = '';
	return esc_url( get_site_icon_url( '32', $fallback_url ) );
}

if ( ! function_exists( 'mynote_author_card' ) ) {
	/**
	 * The author card.
	 *
	 * @param integer $avatar_size The avatar size.
	 * @param string  $icon_size   The social icon size. sm: 24px. md: 32px. lg: 48px. xl: 64px.
	 *
	 * @return void
	 */
	function mynote_author_card( $avatar_size = 96, $icon_size = 'sm' ) {
		$description = get_the_author_meta( 'description' );
		?>
			<h3 class="section-title"><?php esc_html_e( 'Author', 'mynote' ); ?></h3>
			<aside class="author-card" itemscope itemprop="author" itemtype="http://schema.org/Person">
				<div class="author-avatar">
					<img src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => $avatar_size ) ) ); ?>" class="rounded-circle" itemprop="image">
				</div>
				<div class="author-info">
					<div class="author-title">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="name">
							<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
						</a>
					</div>
					<div class="author-description" itemprop="description">  
						<?php echo $description; ?>
					</div>
				</div>
			</aside>
		<?php
	}
}
/**
 * Bootstrap 4 styled category buttons.
 */
function mynote_category() {
	$categories = get_the_category();

	foreach ( $categories as $category ) {
		echo '<a class="btn btn-xs btn-green" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><i class="fas fa-star"></i>' . esc_html( $category->cat_name ) . '</a>';
	}
}

/**
 * Replace the default admin bar callback.
 * Move it to page bottom, because I would like to stick the page title progress bar on page top.
 */
function githuner_admin_bar() {
?>
	<style type="text/css" media="screen" id="githuner-admin-bar">
		html { margin-top: 0px !important; margin-bottom: 32px !important; }
		* html body { margin-top: 0px !important; margin-bottom: 32px !important; }
		#wpadminbar { position: fixed !important; top: auto !important; bottom: 0 !important; display: block !important; }
		@media screen and ( max-width: 782px ) {
			html { margin-top: 0px !important; margin-bottom: 46px !important; }
			* html body { margin-top: 0px !important; margin-bottom: 46px !important; }
		}
	</style>
<?php
}

/**
 * Show category labels on homepage.
 * Parent only.
 *
 * @return void
 */
function mynote_category_labels() {
	$categories = get_categories();

	$i = 0;
	foreach ( $categories as $cat ) {
		if ( ! empty( $cat->parent ) ) {
			// Only shows parent catrgories.
			continue;
		}
		echo '<a href="' . esc_url( get_term_link( $cat->slug, 'category' ) ) . '" class="x-label x-label-' . $i . '">' . esc_html( $cat->name ) . '</a>';
		if ( 10 === ++$i ) {
			$i = 0;
		}
	}
}

/**
 * Display site information on bottom of page.
 *
 * @return void
 */
function mynote_site_info() {
	echo esc_html__( 'Copyright', 'mynote' ) . ' &copy; ' . date( 'Y' ) . ' <strong><a href="' . esc_url( get_site_url() ) . '">' . get_bloginfo( 'name' ) . '</a></strong>. ' . esc_html__( 'All rights reserved.', 'mynote' ) . ' ';

	// Only homepage shows the theme credit link on the footer.
	// Keeping the theme credit link (just one link in your homepage) encourages me to improve this theme better. Thank you.
	if ( is_home() || is_front_page() ) {
		$theme_link = 'https://terryl.in/';
		echo esc_html__( 'Theme by', 'mynote' ) . ' <a href="' . esc_url( $theme_link ) . '">' . esc_html__( 'Mynote', 'mynote' ) . '</a>. ';
	}
}

/**
 * Breadcrumb for single post.
 *
 * @return void
 */
function mynote_post_breadcrumb() {
	global $post;

	if ( is_singular() ) {
		$categories   = get_the_category( $post->ID );

		$is_first_cat = false;
		foreach ( $categories as $cat ) {
			if ( empty( $cat->parent ) && ! $is_first_cat ) {
				$is_first_cat = true;
				$first_cat = $cat;
			}
		}
		// Looking for child category.
		$is_child_cat = false;
		foreach ( $categories as $cat ) {
			if ( $cat->category_parent === $first_cat->cat_ID && ! $is_child_cat ) {
				$is_child_cat = true;
				$child_cat = $cat;
			}
		}
		$pos = 1;

		?>
		<nav class="breadcrumb">
			<div class="container">
				<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
					<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a href="<?php echo esc_url( get_home_url() ); ?>" itemprop="item">
							<span itemprop="name"><i class="fas fa-globe"></i><span class="sr-only"><?php esc_html_e( 'Home', 'mynote' ); ?></span></span>
						</a>
						<meta itemprop="position" content="<?php echo $pos++; ?>">
					</li>
					<?php if ( ! empty( $first_cat ) ) : ?>
					<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a href="<?php echo esc_url( get_term_link( $first_cat->slug, 'category' ) ); ?>" itemprop="item">
							<span itemprop="name"><?php echo esc_html( $first_cat->name ); ?></span>
						</a>
						<meta itemprop="position" content="<?php echo $pos++; ?>">
					</li>
					<?php endif; ?>
					<?php if ( ! empty( $child_cat ) ) : ?>
					<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a class="breadcrumb-item" href="<?php echo esc_url( get_term_link( $child_cat->slug, 'category' ) ); ?>" itemprop="item">
							<span itemprop="name"><?php echo esc_html( $child_cat->name ); ?></span>
						</a>
						<meta itemprop="position" content="<?php echo $pos++; ?>">
					</li>
					<?php endif; ?>
					<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<span itemprop="name"><?php the_title(); ?></span>
						<meta itemprop="item" content="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
						<meta itemprop="position" content="<?php echo $pos++; ?>">
					</li>
				</ul>
			</div>
		</nav>
		<?php
	}
}
