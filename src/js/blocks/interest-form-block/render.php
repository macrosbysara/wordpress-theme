<?php
/**
 * Interest Form Block
 *
 * @package MacrosBySara
 */

$select_options = array(
	array(
		'name'  => '1:1 macro-based coaching',
		'value' => 'macros',
	),
	array(
		'name'  => '1:1 habit-based coaching',
		'value' => 'habits',
	),
	array(
		'name'  => 'One-Time Macro Consultation',
		'value' => 'one-time-macros',
	),
	array(
		'name'  => 'Fitness Coaching',
		'value' => 'fitness',
	),
);


$border_radius           = $attributes['borderRadius'] ?? '0px';
$input_border            = $attributes['inputBorder'] ?? array(
	'color' => 'var(--wp--preset--color--primary)',
	'width' => '2px',
);
$button_color            = $attributes['buttonColor'] ?? 'var(--wp--preset--color--primary)';
$button_background_color = $attributes['buttonBackgroundColor'] ?? 'var(--wp--preset--color--primary)';
$button_border           = $attributes['buttonBorder'] ?? array(
	'color' => 'var(--wp--preset--color--primary)',
	'width' => '1px',
);
$block_gap               = $attributes['style']['spacing']['blockGap'] ?? '1rem';
$style_arr               = array(
	'--gap'                     => $block_gap,
	'--border-radius'           => $border_radius,
	'--input-border-color'      => $input_border['color'],
	'--input-border-width'      => $input_border['width'],
	'--button-color'            => $button_color,
	'--button-background-color' => $button_background_color,
	'--button-border-color'     => $button_border['color'],
	'--button-border-width'     => $button_border['width'],
);

$block_props = get_block_wrapper_attributes(
	array(
		'style'  => implode(
			';',
			array_map(
				function ( $key, $value ) {
					return $key . ':' . $value;
				},
				array_keys( $style_arr ),
				$style_arr
			)
		),
		'method' => 'post',
		'action' => '/wp-json/mbs/v1/forms/interest-form',
	)
);
?>
<form <?php echo $block_props; ?>>
	<div class="col-md-6 form-floating">
		<input type="text" class="form-control" id="mbs-first-name" name="firstName" placeholder="First name" autocomplete="given-name" />
		<label for="mbs-first-name">First name</label>
	</div>

	<div class="col-md-6 form-floating">
		<input type="text" class="form-control" id="mbs-last-name" name="lastName" placeholder="Last name" autoComplete="family-name" />
		<label for="mbs-last-name">Last name</label>
	</div>

	<div class="col-12 form-floating">
		<input type="email" class="form-control" id="mbs-email" name="email" placeholder="name@example.com" autocomplete="email" />
		<label for="mbs-email">Email address</label>
	</div>

	<div class="col-12 form-floating">
		<select class="form-select" id="mbs-interest" name="interest" aria-label="Interest">
			<option value="" disabled selected>I&apos;m interested in&hellip;</option>
			<?php foreach ( $select_options as $option ) : ?>
			<option value="<?php echo esc_attr( $option['value'] ); ?>">
				<?php echo esc_html( $option['name'] ); ?>
			</option>
			<?php endforeach; ?>
		</select>
		<label for="mbs-interest">Interest</label>
	</div>
	<div class="form-footer">
		<button type="submit">Submit</button>
		<div class=" response-area"></div>
		<?php
		if ( defined( 'CF_TURNSTILE_SECRET' ) && ! empty( CF_TURNSTILE_SECRET ) ) {
			echo '<div class="cf-turnstile" data-sitekey="0x4AAAAAACAcVKqyxt1TEIP2" data-appearance="interaction-only"></div>';
		}
		?>
	</div>
</form>
