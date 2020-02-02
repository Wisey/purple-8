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
				foreach($chars AS $index => $char):

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
				endforeach;

				$fewest_zeroes = NULL;
				foreach($layers AS $index => $layer){
					if(empty($fewest_zeroes) || $layer->zeroes < $layers[$fewest_zeroes]->zeroes){
						$fewest_zeroes = $index;
					}
				}

				echo "Day 8 Answer: ".verification($layers[$fewest_zeroes]);
			?>
		</div>
	</div>

<?php endif; ?>
