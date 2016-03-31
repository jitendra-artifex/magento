<?php
header("Content-type: text/css; charset: UTF-8");

/**
 * @category	Solide Webservices
 * @package		Flexslider
*/

require_once (dirname(__FILE__).'../../../../../../../') . '/app/Mage.php';
umask(0);
Mage::app();

$model = Mage::getModel('flexslider/group')->getCollection();
foreach ($model as $group) :
?>


/********************************[ STYLES FOR SLIDER <?php echo $group['code'] ?> ]***********************************/

/* -----------[ THEME ] ----------*/
<?php if($group['theme'] == 'default'): ?>
	<?php /*?>.<?php echo $group['code'] ?>-container .sw-flexslider-container { box-shadow: 1px 1px 2px #888; margin: 10px 2px; }<?php */?>
    .<?php echo $group['code'] ?>-container .sw-flexslider-container { /*box-shadow: 1px 1px 2px #888;*/ margin: 0px 2px; }
	.<?php echo $group['code'] ?>-container .sw-flexslider {}
	.<?php echo $group['code'] ?>-container .sw-flexslider .slides .slider-title { right: 0; bottom: 30px; width: 46%; background: rgba(0, 0, 0, 0.6); color: #fff; padding: 10px 20px 10px 20px; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { background: #fff; border: 1px solid #333; box-shadow: 0 0 2px rgba(0, 0, 0, 0.4) inset; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a.sw-flexslider-active { background-color: #999; border-color: #333; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a:hover { background-color: #ccc; border-color: #111; }
<?php elseif($group['theme'] == 'woothemes'): ?>
	.<?php echo $group['code'] ?>-container .sw-flexslider { background-color: #fff; border: 4px solid #fff; border-radius: 4px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2); margin: 10px 2px; }
	.<?php echo $group['code'] ?>-container .sw-flexslider .slides .slider-title {	left: 0; bottom: 0;	width: 100%; background: rgba(0, 0, 0, 0.6); color: #fff; padding: 10px 20px 10px 20px; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { background: #fff; border: 1px solid #3B5481; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a.sw-flexslider-active { background: #293F67; border-color: #000; box-shadow: 0 0 1px rgba(255, 255, 255, 0.3), 0 0 1px rgba(0, 0, 0, 0.6) inset; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a:hover { background-color: #ccc; border-color: #111; }
<?php elseif($group['theme'] == 'blank'): ?>
	/* only styles for pagination in blank theme */
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { background: #fff; border: 1px solid #333; box-shadow: 0 0 2px rgba(0, 0, 0, 0.4) inset; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a.sw-flexslider-active { background-color: #999; border-color: #333; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a:hover { background-color: #ccc; border-color: #111; }
<?php elseif($group['theme'] == 'custom'): ?>
	@import url('<?php echo $group['code'] ?>-custom.css');
<?php else: ?>
	.<?php echo $group['code'] ?>-container .sw-flexslider-container { box-shadow: 1px 1px 2px #888; margin: 10px 2px; }
	.<?php echo $group['code'] ?>-container .sw-flexslider { background-color: #fff; box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2); border: 1px solid #fff; margin: 0; padding: 6px; }
	.<?php echo $group['code'] ?>-container .sw-flexslider .slides .slider-title { right: 0; bottom: 30px; width: 46%; background: rgba(0, 0, 0, 0.6); color: #fff; padding: 10px 20px 10px 20px; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { background: #fff; border: 1px solid #333; box-shadow: 0 0 2px rgba(0, 0, 0, 0.4) inset; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a.sw-flexslider-active { background-color: #999; border-color: #333; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a:hover { background-color: #ccc; border-color: #111; }
<?php endif; ?>

/* -----------[ NAVIGATION STYLE ] ----------*/
<?php if($group['nav_style'] == 'circular'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-prev:before { content: "\33"; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-next:before { content: "\34"; }
<?php elseif($group['nav_style'] == 'square'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-prev:before { content: "\39"; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-next:before { content: "\30"; }
<?php else: ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-prev:before { content: "\33"; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-next:before { content: "\34"; }
<?php endif; ?>

/* -----------[ NAVIGATION VISIBILITY ] ----------*/
<?php if($group['nav_show'] == 'hover'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav a { opacity: 0; transition: all 200ms ease-in-out; -webkit-transition: all 200ms ease-in-out; -moz-transition: all 200ms ease-in-out; -o-transition: all 200ms ease-in-out; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav a { font-size: 26px; opacity: 0.8; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-next:hover, .flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-prev:hover { opacity: 0.9; }
<?php elseif($group['nav_show'] == 'always'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav a, #carousel-<?php echo $group['code'] ?>.carousel .sw-flexslider-direction-nav a { opacity: 0.8; transition: all 200ms ease-in-out; -webkit-transition: all 200ms ease-in-out; -moz-transition: all 200ms ease-in-out; -o-transition: all 200ms ease-in-out; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-next:hover, .flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-prev:hover { opacity: 0.9; }
<?php elseif($group['nav_show'] == 'no'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav a { opacity: 0; }
<?php else: ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav a { opacity: 0; transition: all 200ms ease-in-out; -webkit-transition: all 200ms ease-in-out; -moz-transition: all 200ms ease-in-out; -o-transition: all 200ms ease-in-out; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav a { font-size: 26px; opacity: 0.8; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-next:hover, .flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-prev:hover { opacity: 0.9; }
<?php endif; ?>

/* -----------[ NAVIGATION POSITION ] ----------*/
<?php if($group['nav_position'] == 'inside'): ?>
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-next { right: 12px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-prev { left: 12px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-next { right: 10px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-prev { left: 10px; }
<?php elseif($group['nav_position'] == 'inside-left'): ?>
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-next { left: 42px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-prev { left: 12px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-next { left: 40px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-prev { left: 14px; }
<?php elseif( $group['nav_position'] == 'inside-right'  ) : ?>
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-next { right: 12px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-prev { right: 42px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-next { right: 14px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-prev { right: 40px; }
<?php elseif($group['nav_position'] == 'outside'): ?>
	#<?php echo $group['code'] ?>-nav-container { margin: 0 33px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-next { right: -38px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-prev { left: -38px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-next { right: -36px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-prev { left: -36px; }
<?php else: ?>
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-next { right: 12px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-direction-nav .sw-flexslider-prev { left: 12px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-next { right: 10px; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider .sw-flexslider-direction-nav .sw-flexslider-prev { left: 10px; }
<?php endif; ?>

/* -----------[ NAVIGATION COLOR ] ----------*/
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-prev:before, .flexslider-<?php echo $group['code'] ?> .sw-flexslider-direction-nav .sw-flexslider-next:before { color: <?php echo $group['nav_color'] ?>; }
	
/* -----------[ PAGINATION STYLE ] ----------*/
<?php if($group['pagination_style'] == 'circular'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { border-radius: 8px; }
<?php elseif($group['pagination_style'] == 'squared'): ?>
	/* no extra styling needed */
<?php elseif($group['pagination_style'] == 'circular-bar'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { box-shadow: 1px 0 2px rgba(0, 0, 0, 0.7) inset; background: rgb(181,189,200); background: -moz-linear-gradient(top, rgba(181,189,200,1) 3%, rgba(130,140,149,1) 17%, rgba(40,52,59,1) 92%); background: -webkit-gradient(linear, left top, left bottom, color-stop(3%,rgba(181,189,200,1)), color-stop(17%,rgba(130,140,149,1)), color-stop(92%,rgba(40,52,59,1))); background: -webkit-linear-gradient(top, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); background: -o-linear-gradient(top, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); background: -ms-linear-gradient(top, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); background: linear-gradient(to bottom, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 ); border-radius: 2px; padding: 2px 6px !important; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { border-radius: 8px; }
<?php elseif($group['pagination_style'] == 'square-bar'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { box-shadow: 1px 0 2px rgba(0, 0, 0, 0.7) inset; background: rgb(181,189,200); background: -moz-linear-gradient(top, rgba(181,189,200,1) 3%, rgba(130,140,149,1) 17%, rgba(40,52,59,1) 92%); background: -webkit-gradient(linear, left top, left bottom, color-stop(3%,rgba(181,189,200,1)), color-stop(17%,rgba(130,140,149,1)), color-stop(92%,rgba(40,52,59,1))); background: -webkit-linear-gradient(top, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); background: -o-linear-gradient(top, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); background: -ms-linear-gradient(top, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); background: linear-gradient(to bottom, rgba(181,189,200,1) 3%,rgba(130,140,149,1) 17%,rgba(40,52,59,1) 92%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 ); border-radius: 2px; padding: 2px 6px !important; }
<?php else: ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging li a { border-radius: 10px 10px 10px 10px; }
<?php endif; ?>

/* -----------[ PAGINATION VISIBILITY ] ----------*/
<?php if($group['pagination_show'] == 'hover'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { opacity: 0; transition: all 200ms ease-in-out; -webkit-transition: all 200ms ease-in-out; -moz-transition: all 200ms ease-in-out; -o-transition: all 200ms ease-in-out; }
	.flexslider-<?php echo $group['code'] ?>.sw-flexslider:hover .sw-flexslider-control-paging { opacity: 1; }
<?php endif; ?>

/* -----------[ PAGINATION POSITION ] ----------*/
<?php if($group['pagination_position'] == 'below'): ?>
	<?php /*?>.<?php echo $group['code'] ?>-container { padding-bottom: 10px; }<?php */?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { bottom: -30px !important; }
<?php elseif($group['pagination_position'] == 'inside-bottom'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { bottom: 10px !important; }
<?php elseif($group['pagination_position'] == 'inside-top'): ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { top: 15px !important; }
<?php elseif($group['pagination_position'] == 'above'): ?>
	.<?php echo $group['code'] ?>-container { padding-top: 30px; }
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { top: -30px !important; }
<?php else: ?>
	.flexslider-<?php echo $group['code'] ?> .sw-flexslider-control-paging { bottom: -30px !important; }
<?php endif; ?>

<?php
endforeach;
?>