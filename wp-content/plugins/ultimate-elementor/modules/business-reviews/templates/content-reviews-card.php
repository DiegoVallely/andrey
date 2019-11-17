<?php
/**
 * UAEL Reviews - Template.
 *
 * @package UAEL
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$photolink = ( null !== $review['profile_photo_url'] ) ? $review['profile_photo_url'] : ( UAEL_URL . 'assets/img/user.png' );
?>
<div class="uael-review-wrap">
	<div class="uael-review uael-review-type-<?php echo $review['source']; ?>">
		<?php if ( 'yes' === $this->get_instance_value( 'reviewer_image' ) && 'all_left' === $this->get_instance_value( 'image_align' ) ) { ?>
			<div class="uael-review-image" style="background-image:url( <?php echo $photolink; ?> );"></div>
		<?php } ?>
		<div class="uael-review-inner-wrap">
			<?php if ( 'yes' === $this->get_instance_value( 'review_content' ) ) { ?>
				<?php
				$the_content = $review['text'];
				if ( '' !== $this->get_instance_value( 'review_content_length' ) ) {
					$the_content    = strip_tags( $review['text'] ); // Strips tags.
					$content_length = $this->get_instance_value( 'review_content_length' ); // Sets content length by word count.
					$words          = explode( ' ', $the_content, $content_length + 1 );
					if ( count( $words ) > $content_length ) {
						array_pop( $words );
						$the_content  = implode( ' ', $words ); // put in content only the number of word that is set in $content_length.
						$the_content .= '...';
						if ( '' !== $this->get_instance_value( 'read_more' ) ) {
							$the_content .= '<a href="' . $review['review_url'] . '"  target="_blank" rel="noopener noreferrer" class="uael-reviews-read-more">' . $this->get_instance_value( 'read_more' ) . '</a>';
						}
					}
				}
				?>
				<div class="uael-review-content"><?php echo $the_content; ?></div>
				<?php $this->get_reviews_header( $review, $photolink, $settings ); ?>
			<?php } ?>
		</div>
	</div>
</div>
<?php
