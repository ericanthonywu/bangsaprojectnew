<?php
$title 			= "Cari Berita | Bangsa Online - Cepat, Lugas dan Akurat";
$image 			= Yii::app()->getBaseUrl(true) ."/img/logo.png";
$sitename 		= "Harian Bangsa Online";
$description 	= "Portal Berita Harian Bangsa Online - Cepat, Lugas dan Akurat";
$keyword 		= "jatim,jatim timur";
$url			= Yii::app()->getBaseUrl(true);

$this->pageTitle = $title;
// Facebook OG
Yii::app()->facebook->ogTags['og:title'] 		= $title; 
Yii::app()->facebook->ogTags['og:image'] 		= $image; 
Yii::app()->facebook->ogTags['og:site_name'] 	= $sitename;
Yii::app()->facebook->ogTags['og:description'] 	= $description; 
Yii::app()->facebook->ogTags['og:type'] 		= "article"; 
Yii::app()->facebook->ogTags['og:url'] 			= $url; 

// Meta tag
Yii::app()->clientScript->registerMetaTag($description, 'description');
Yii::app()->clientScript->registerMetaTag($keyword, 'keywords');

$this->breadcrumbs=array(
	'Cari Berita',
);
?>
<div class="row bo-main">
	<!-- KONTEN -->
	<div class="span8 mb1 mt1"> 
		<div class="breadcrumb">
			<?php 
				$this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				));
			?>
		</div>
		
		<div class="title-search"><h1>Hasil Cari : <?php echo $cari; ?></h1></div>
		
		<div class="separator-block-2 mt2 mb2"></div> <!-- Spearator -->
		<!-- Start List Berita -->
		<div class="list-search-berita">
		<?php 	
				if(count($model)>0):
				foreach ($model as $quer):
		?>
				<div class="berita-row mb1">
					<?php if(isset($quer['filename'])): ?>
					<div class="left-search-berita">
						<div class="image-search-berita"><?php echo get_image($quer['filename'],"berita","150x150"); ?></div>
					</div>
					<?php endif;?>
					<div class="right-search-berita" <?php if(empty($quer['filename'])){ ?>style="width:100%!important"<?php } ?>>
						<div class="title-search-berita">
							<h3><a href="<?php echo get_link_berita("berita", $quer['news_id'], $quer['news_slug']); ?>"><?php echo $quer['news_title']; ?></a></h3>
						</div>
						<div class="date-search-berita"><?php echo get_time($quer['news_date'],"d F Y | H:i","yes"); ?><span class="total_comment"> | 
						<?php echo (isset($quer['cc']))? $quer['cc']:"0"; ?> Komentar</span> </div>
						<div class="excerpt-search-berita">
							<?php echo get_excerpt($quer['news_content'],360); ?>
							<span class="readmore_button"><a href="<?php echo get_link_berita("berita", $quer['news_id'], $quer['news_slug']); ?>">Baca Selanjutnya</a></span>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
		<?php	endforeach;
				else:?>
					Maaf, hasil pencarian tidak ditemukan
		<?php 	endif;?>
		</div>
		<div class="pagination">
			<?php 
				$this->widget('CLinkPager', array(
					'itemCount'		=> $item_count,
					'pageSize'		=> $page_size,
					'header'=>'',
					'maxButtonCount' => 5,
					'htmlOptions'=>array('class'=>''),
				));
			?>
		</div>
		
	</div>
	
	<!-- SIDEBAR -->
	<div class="span4 mb1 mt1">
		<?php $this->renderPartial('//site/sidebar'); ?>
	</div>
</div>