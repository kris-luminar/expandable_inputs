<style type="text/css">
    div.wrapper{
        width: 80%;
    }
</style>
<p>Thank you for submitting the below contact information for your offices!</p>
<div id="output_table">
    <?php echo $this->table->generate($this->session->userdata('expandable_input')); ?>
</div>