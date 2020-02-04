<?php
	class Layer {
		public $zeroes	= 0;
		public $ones	= 0;
		public $twos	= 0;
		public $image	= NULL;
	}

	// Return required sum of multiplication for puzzle solution
	function verification($layer){
		if(!empty($layer)){
			if(isset($layer->ones) && isset($layer->twos)){
				return $layer->ones * $layer->twos;
			}
		}
		return FALSE;
	}

	$layers = [];
?>

<style>
	body {
		background-color: #666666;
		color: #FFFFFF;
	}

	td.black {
		background-color: #000000;
	}

	td.transparent {
		background-color: #666666;
	}

	td.white {
		background-color: #FFFFFF;
	}

	tbody {
		border: none !important;
	}
</style>

<?php if(empty($chars)): ?>
	<!-- Error message if script could not run -->
	<div data-closable class="callout alert-callout-border alert radius">
		<strong>Error</strong> - The file, or the file's contents were not loaded
		<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php else: ?>

	<div class="row">
		<div class="small-12 columns">

			<?php
				if(!empty($chars)){
					foreach($chars AS $index => $char){

						if($index % ($width * $height) == 0){
							/*
							//Image visual - cut out for processing speed
							if(!empty($layer->image)){
								$layer->image = "\n".$layer->image;
							}
							*/

							// Reset object if maximum characters reached.
							$layer = new Layer();
							$layers[] = $layer;
						}

						$layer->image .= $char;

						/*
						//Image visual - cut out for processing speed
						$layer->image .= $char;
						if(strlen(str_replace("\n", "", $layer->image)) % $width == 0){
							$layer->image .= "\n";
						}
						*/

						// Obtain character counts
						switch($char){
							case "0":
								$layers[count($layers) - 1]->zeroes++;
							break;

							case "1":
								$layers[count($layers) - 1]->ones++;
							break;

							case "2":
								$layers[count($layers) - 1]->twos++;
							break;
						}
					}
				}

				$fewest_zeroes = NULL;
				if(!empty($layers)){
					foreach($layers AS $index => $layer){
						if(empty($fewest_zeroes) || $layer->zeroes < $layers[$fewest_zeroes]->zeroes){
							$fewest_zeroes = $index;
						}
					}
				}

				echo "<p>Day 8, Part I Answer: ".verification($layers[$fewest_zeroes])."</p>";

				echo "<p>Day 8, Part II Answer:</p>";

				// Formulate Final Image
				$output_string = [];
				if(!empty($layers)){
					foreach($layers AS $layer){
						if(!empty(str_split($layer->image))){
							foreach(str_split($layer->image) AS $pIndex => $pixel){
								// If not set, we know we can put any pixel there
								if(!isset($output_string[$pIndex])){
									$output_string[] = $pixel;
								}elseif($output_string[$pIndex] == 2){
									// If it is set, and is transparent, we can overwrite pixel
									$output_string[$pIndex] = $pixel;
								}
							}
						}
					}
				}
			?>
				<table>
					<tr>
						<?php
							if(!empty($output_string)):
								foreach($output_string AS $pIndex => $pixel):
										// Colouration options
										switch($pixel){
											case "0":
												$class = "black";
											break;

											case "1":
												$class = "white";
											break;

											case "2":
												$class = "transparent";
											break;
										}

										// New line on meeting max width
										if($pIndex > 0 && $pIndex % $width == 0):
											?>
												</tr>
												<tr>
											<?php
										endif;

									?>
										<td class="<?=$class;?>">
										</td>
									<?php
								endforeach;
							endif;
						?>
					</tr>
				</table>
		</div>
	</div>

<?php endif; ?>
