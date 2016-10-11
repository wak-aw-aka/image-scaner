<?php
$this->title = 'Найденые изображения по url ' . $urlImg->url;
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Найденые изображения по url <?php echo $urlImg->url;?> в <?php echo date('H:i:s d-m-Y');?></h2>
                <div class = "imgWrap">
                	<?php foreach(json_decode($urlImg->data, true) as $imgSrc): ?>
                		<img src = "<?php echo $imgSrc;?>">
                	<?php endforeach;?>
                </div>

            </div>

        </div>

    </div>
</div>