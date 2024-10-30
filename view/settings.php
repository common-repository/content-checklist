<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-09-01
 * Time: 13:02
 */

?>
<div class="wrap">
    <h1>Content Checklist</h1>

    <form method="post" action="options.php">
        <?php settings_fields('wpcc'); ?>
        <?php do_settings_sections('wpcc'); ?>
        <table class="form-table">

            <!-- Word Limit -->
            <tr valign="top">
                <th scope="row">Word Limit (<span style="color: #7ad03a !important">Green</span>)</th>
                <td><input type="text" name="wpcc_word_limit_green"
                           value="<?= \Edlin\ContentChecklist\App\Settings::getWordLimitGreen() ?>"/></td>
            </tr>
            <!-- End Word Limit -->

            <!-- Word Limit Orange -->
            <tr valign="top">
                <th scope="row">Word Limit (<span style="color: #ee7c1b !important">Orange</span>)</th>
                <td><input type="text" name="wpcc_word_limit_orange"
                           value="<?= \Edlin\ContentChecklist\App\Settings::getWordLimitOrange() ?>"/></td>
            </tr>
            <!-- End Word Limit Orange -->

        </table>

        <?php submit_button(); ?>

    </form>

</div>