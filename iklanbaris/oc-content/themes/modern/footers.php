<?php
    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    osc_show_widgets('footer');
?>


</div>
<!-- /container -->
<!-- footer -->
<div id="footer">
    <div class="wrapper">
<div class="horbar-bevel"></div>

<div class="footend">
  <a href="<?php echo osc_base_url(); ?>"><strong itemprop="copyright">© 2013</strong></a>
        <ul>
               
            <?php osc_reset_static_pages() ;
            $i = 1;
            while( osc_has_static_pages() ) {
                $last = '';
                if($i == osc_count_static_pages()){
                    $last = 'class="last"';
                }
            ?>
                <li <?php echo $last; ?>><a href="<?php echo osc_static_page_url() ; ?>"><?php echo osc_static_page_title() ; ?></a></li>
  
            <?php
                $i++;
            }
            ?>  
            <li><strong><a href="<?php echo osc_contact_url(); ?>"><?php _e('Kontak Kami', 'realestate') ; ?></a></strong></li>



        </ul>
</div>
       </div>
    </div>


</div>
</div> 

<!-- /footer --><script type="text/javascript">
    var sQuery = '<?php echo $sQuery ; ?>' ;
    function doSearch() {
        if($('input[name=sPattern]').val() == sQuery || ( $('input[name=sPattern]').val() != '' && $('input[name=sPattern]').val().length < 0 ) ) {
            $('input[name=sPattern]').css('background', '#FFC6C6');
            $('#search-example').text('<?php echo osc_esc_js( __('Your search must be at least one characters long','modern') ) ; ?>')
            return false;
        }
        return true;
    }
</script>

<?php osc_run_hook('footer') ; ?>