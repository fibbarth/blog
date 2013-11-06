<?php
require 'countries.php';

$logos = array(
				'200-100'		  => 'http://static.zend.com/img/yellowpages/PHP-4-icon.png',
				'200-550'		  => 'http://static.zend.com/img/yellowpages/ZCPE-icon.png',
				'200-530' 		  => 'http://static.zend.com/img/yellowpages/PHP-5-3-icon.png',
				'200-500' 		  => 'http://static.zend.com/img/yellowpages/PHP-5-icon.png',
				'ZF-100-500'	  => 'http://static.zend.com/img/yellowpages/ZF-icon.png'
		);

$nameCountry = str_replace('zce', '', $_GET['country']);
$field = array(
        "cid"                => $countries[$nameCountry],
        "ClientCandidateID" => "",
        "certtype"             => "",
        "certtype_php"         => "1",
        "certtype_zf"        => "1",
        "company"            => "",
        "firstname"            => "",
        "lastname"            => "",
        "sid"                => ""
);
$fields_string = http_build_query($field);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.zend.com/en/store/education/certification/yellow-pages.php');
curl_setopt($ch,CURLOPT_POST, count($field));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, 'http://www.zend.com/en/yellow-pages');
$jsonUsers = urldecode(curl_exec($ch));
$zces = json_decode($jsonUsers);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,700' rel='stylesheet' type='text/css'/>
		<link rel="stylesheet" type="text/css" href="css/template.css"/>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.mixitup.min.js"></script>
		<script type="text/javascript">
		
			/* 
			*	We would normally recommend that all JavaScript is kept in a seperate .js file,
			* 	but we have included it in the document head for convenience.
			*/
			
			// INSTANTIATE MIXITUP
		
			$(function(){
				$('#Grid').mixitup({
					 multiFilter: true,
					 showOnLoad: '<?php echo implode(' ',array_keys($logos)); ?>',
					 sortOnLoad: 'data-name',
					 effects:['fade','scale','rotateZ']
				 }
				);
			});
			
		</script>
	</head>
	<body>
		<div class="wrapper">
			<h1>ZCE <?php echo $nameCountry; ?></h1>
			<!-- FILTER CONTROLS -->
			<div class="controls">	
				<h3>Filter Controls</h3>
				<ul>
					<?php 
						foreach( $logos as $k => $v ):
					?>	
							<li class="filter active" data-filter="<?php echo $k; ?>">
								<img title="<?php echo $k; ?>" alt="<?php echo $k; ?>" src="<?php echo $v; ?>" />
							</li>
					<?php 		
						endforeach;
					?>
				</ul>
			</div>
			<hr/>
			<!-- GRID -->
			<h2><strong><?php echo count($zces->data); ?></strong> ZCEs found.</h2>
			<br />
			<ul id="Grid">
				<?php 
					foreach( $zces->data as $zce ): 
  					list($lastName, $firstName) = explode(',',$zce->Name);
					$fullName = trim($firstName.' '.$lastName);
				?>
				<li class="mix <?php echo str_replace(',',' ',$zce->Certs); ?>" data-name="<?php echo $fullName; ?>">
						<img class="zendImage" src="<?php echo ($zce->ZendImage) ? "http://www.zend.com/images/training/zce_photos/{$zce->ZendImage}" : 'css/images/zend_logo.png'; ?>" />
						<div class="personal-data">
							<?php  echo $fullName;	?>
						</div>
						<div class="certifications">
							<?php
								$certifications = explode(',', $zce->Certs);
								if( is_array($certifications) ):
									foreach( $certifications as $cert ):
							?>		
									<img title="<?php echo $cert; ?>" alt="<?php echo $cert; ?>" src="<?php echo $logos[$cert]; ?>" />
							<?php 		
									endforeach;
								endif;
							?>	
						</div>
					</li>
				<?php endforeach; ?>
				<li class="gap"></li> <!-- "gap" elements fill in the gaps in justified grid -->
			</ul>
			
		</div>
	</body>	
</html>