<?php $this->load->view('includes/header');?>
</head>
<body>
<div class="wrapper">
    <h1 class="header"><?php echo $page_heading;?></h1>
<?php $this->load->view($main_content); ?>
</div>

<?php $this->load->view('includes/footer'); ?>