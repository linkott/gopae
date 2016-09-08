<div class="<?php if(isset($class)) echo $class; elseif(isset($classname)) echo $classname; ?>">
    <button type="button" class="close" onclick="$(this).parent().fadeOut('slow');">
        <span aria-hidden="true">&times;</span>
    </button>
    <p>
        <?php if(isset($message)) echo $message; ?>
    </p>
</div>