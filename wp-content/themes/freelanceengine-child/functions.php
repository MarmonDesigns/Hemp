<?php

function register_my_menu() {
  register_nav_menu('new-menu',__( 'Custom Main Menu' ));
}
add_action( 'init', 'register_my_menu' );

function form_creation(){
 ?>
 <div class="hemp_stores">
<h1 class="slider_text_heading">SEARCH HEMP STORES</h1><br>
<li id="categories">
<form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

		<?php
		$args = array(
			'show_option_none' => __( 'Select category' ),
			'show_count'       => 1,
			'orderby'          => 'name',
			'echo'             => 0,
		);
		?>

		<?php $select  = wp_dropdown_categories( $args ); ?>
		<?php $replace = "<select$1 onchange='return this.form.submit()'>"; ?>
		<?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>

		<?php echo $select; ?>

		<noscript>
			<input type="submit" value="View" />
		</noscript>

	</form>
</li>
<?php// wp_dropdown_categories( $args ); ?> 

<!--<select class="state_data" name="store"  form="store">
<option>Select State</option>
  <option value="Haryana">Haryana</option>
  <option value="Punjab">Punjab</option>
  <option value="Delhi">Delhi</option>
 </select> -->
<input class="submit_button"  type="submit" name="submit" value="Go"> 
</div>
 <?php
 }
 add_shortcode('form','form_creation');
 ?>