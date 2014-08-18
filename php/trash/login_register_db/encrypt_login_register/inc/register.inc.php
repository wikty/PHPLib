        <form action='' method='post'>
            <div>
        <?php
        if($_POST && $errors && (array_key_exists(3,$errors) || array_key_exists(2,$errors)))
        {
        echo '<ul>';
        if(!empty($errors[2]))
        {
            foreach($errors[2] as $item)
            {
                echo '<li class="error">'.$item.'</li>';
            }
        }
        else
        {
             foreach($errors[3] as $item)
            {
                echo '<li class="error">'.$item.'</li>';
            }           
        }
        echo '</ul>';
        }
        ?>
            </div>
         <div>
        <label for='name'>用户名：
        </label>
        <?php
        if($_POST && $errors && array_key_exists(0,$errors))
        {
        echo '<ul>';
            foreach($errors[0] as $item)
            {
                echo '<li class="error">'.$item.'</li>';
            }
        echo '</ul>';
        }
        ?>
        
        <input type='text' name='name' id='name' value='<?php if($_POST && $errors) echo $_POST[name]; 
        ?>' />
         </div>
        <div>
        <label for='pwd'>
            密码：
        </label>
        <?php
        if($_POST && $errors && array_key_exists(1,$errors))
        {
        echo '<ul>';
            foreach($errors[1] as $item)
            {
                echo '<li class="error">'.$item.'</li>';
            }
        echo '</ul>';
        }
        ?>
        <input type='password' name='pwd' id='pwd' />
        </div>
        <div>
        <label for='rpwd'>确认密码：</label>
        <input type='password' name='rpwd' id='rpwd' />
        </div>
        <div>
        <input type='submit' value='注册' name='reg' id='reg' />
          </div>
        </form>
  