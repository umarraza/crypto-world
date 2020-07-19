<?php 
    $text = '';
    $level = '';
?>
 @if($errors->any())
    <?php $level = 'error'; ?>
    @foreach($errors->all() as $error)
        <?php
        $text .= '&#8226;'.$error.'<br>';
         ?>
    @endforeach
@elseif(session()->get('flash_success'))
    
    <?php $level = 'success'; ?>
    <?php $text = session()->get('flash_success')?>

        @if(is_array(json_decode(session()->get('flash_success'), true)))
            <?php $text = implode('', session()->get('flash_success')->all(':message<br/>')); ?>
        @endif
@elseif(session()->get('flash_warning'))
        
    <?php $level = 'warning'; ?>
    <?php $text = session()->get('flash_warning') ?>

        @if(is_array(json_decode(session()->get('flash_warning'), true)))
            <?php $text = implode('', session()->get('flash_warning')->all(':message<br/>')); ?>
        @endif
@elseif(session()->get('flash_info'))
    
    <?php $level = 'info'; ?>
    <?php $text = session()->get('flash_info') ?>

        @if(is_array(json_decode(session()->get('flash_info'), true)))
            <?php $text = implode('', session()->get('flash_info')->all(':message<br/>')); ?>
        @endif
@elseif(session()->get('flash_danger'))
    <?php $level = 'error'; ?>
    <?php $text = session()->get('flash_danger') ?>

        @if(is_array(json_decode(session()->get('flash_danger'), true)))
            <?php $text = implode('', session()->get('flash_danger')->all(':message<br/>')); ?>
        @endif
@elseif(session()->get('flash_message'))
    <?php $level = 'info'; ?>
    <?php $text = session()->get('flash_message') ?>

        @if(is_array(json_decode(session()->get('flash_message'), true)))
            <?php $text = implode('', session()->get('flash_message')->all(':message<br/>')); ?>
        @endif
@endif

<script>
    var text = "<?= $text ?>";
    var level = "<?= $level ?>";

    $(document).ready(function(){
        if(text != '' && level != ''){
            switch(level){
                case 'success':
                    toastr.success(text)
                break;
                case 'error':
                    toastr.error(text)
                break;
                case 'info':
                    toastr.info(text)
                break;
                case 'warning':
                    toastr.warning(text)
                break;
            }
        }
    });
</script>