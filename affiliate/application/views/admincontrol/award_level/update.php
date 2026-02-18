<?php if($award_level_status){ ?>
    <div class="content-body">
        <div class="card award-level">
            <div class="card-header d-flex justify-content-between">
                <h6 class="text-primary font-weight-bold"><?= __('admin.award_level') ?></h6>
                <a href="<?= base_url('admincontrol/award_level') ?>" class="btn btn-sm btn-primary pull-right">
                    <?= __('admin.back') ?>
                </a>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-content">
                        <div class="form-group">
                            <label>
                                <?= __('admin.level_number') ?>
                                <span class="field-description" data-toggle="tooltip" title="<?= __('admin.award_level_level_number_desc') ?>">
                                </span>
                            </label>
                            <input type="text" class="form-control" name="level_number" value="<?= $award_level['level_number'] ?>" placeholder="<?= __('admin.level_number') ?>">
                            <p class="error-message"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <?= __('admin.jump_level') ?>
                                <span class="field-description <?= ($award_level['jump_level'] == '0') ? 'd-none' : '' ?>" data-toggle="tooltip" title="<?= __('admin.award_level_jump_level_desc') ?>"></span>
                                <span class="field-description default-level-description <?= ($award_level['jump_level'] == '0') ? '' : 'd-none' ?>" data-toggle="tooltip" title="<?= __('admin.award_level_jump_default_level_desc') ?>"></span>
                            </label>
                            <select class="form-control" name="jump_level">
                                <option value=''><?= __('admin.choose_jump_level') ?></option>
                                <option <?= ($award_level['jump_level'] == '0') ? 'selected' : '' ?> value="0"><?= __('admin.default') ?></option>
                                <?php foreach($award_levels as $key => $value): ?>
                                    <?php $class = ($value['id'] == $award_level['jump_level']) ? 'selected' : '' ?>
                                    <option <?= $class ?> value="<?= $value['id'] ?>"><?= $value['level_number'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <p class="error-message"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <?= __('admin.minimum_earning') ?>
                                <span class="field-description" data-toggle="tooltip" title="<?= __('admin.award_level_minimum_earning_desc') ?>"></span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text refer-reg-symball"><?= $CurrencySymbol ?></span>
                                </div>
                                <input type="number" class="form-control" name="minimum_earning" min="0" step="0.01" value="<?= $award_level['minimum_earning'] ?>" placeholder="<?= __('admin.minimum_earning') ?>">
                            </div>
                            <p class="error-message"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <?= __('admin.sale_comission_rate') ?>
                                <span class="field-description" data-toggle="tooltip" title="<?= __('admin.award_level_sale_comission_rate_desc') ?>"></span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text refer-reg-symball">%</span>
                                </div>
                                <input type="number" class="form-control" name="sale_comission_rate" min="0" step="0.01" value="<?= $award_level['sale_comission_rate'] ?>" placeholder="<?= __('admin.sale_comission_rate') ?>">
                            </div>
                            <p class="error-message"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <?= __('admin.bonus') ?>
                                <span class="field-description" data-toggle="tooltip" title="<?= __('admin.award_level_bonus_desc') ?>"></span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text refer-reg-symball"><?= $CurrencySymbol ?></span>
                                </div>
                                <input type="number" class="form-control" name="bonus" min="0" step="0.01" value="<?= $award_level['bonus'] ?>" placeholder="<?= __('admin.bonus') ?>">
                            </div>
                            <p class="error-message"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <?= __('admin.set_default') ?>
                                <span class="field-description" data-toggle="tooltip" title="<?= __('admin.award_level_default_desc') ?>"></span>
                            </label>
                            <input type="checkbox" class="form-control" name="default_registration_level" <?= ($award_level['default_registration_level']) ? 'checked' : '' ?> value="1">
                            <p class="error-message"></p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mr-3"><?= __('admin.save') ?></button>
                        <button type="submit" class="btn btn-info" data-redirect='true'><?= __('admin.save_and_close') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("button[type='submit']").on('click',function(e){
            e.preventDefault();

            $this = $(this);
            let form = $this.parents('form');
            let url = form.attr('action');

            $.ajax({
                type:'POST',
                dataType:'json',
                data:form.serialize(),
                success:function(result){
                    $("input").removeClass('error');
                    $(".error-message").text('');

                    if(result.validation){
                        $.each(result.validation,function(key,value){
                            $("input[name='"+key+"']").addClass('error');
                            $("input[name='"+key+"']").siblings('.error-message').text(value);
                        }) 
                    } else {
                        if(result.status){
                            Swal.fire({
                                icon: 'success',
                                html: result.message,
                            }).then(function(){
                                let redirect = $this.data('redirect');
                                if(redirect)
                                    window.location= '<?= base_url('admincontrol/award_level') ?>';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: result.message,
                            });
                        }
                    }
                },
            }); 
        })

        $("select[name='jump_level']").on('change',function(){
            let value = $(this).val();
            if(value == '0'){
                $(this).siblings('label').find('.field-description').addClass('d-none');
                $(this).siblings('label').find('.field-description.default-level-description').removeClass('d-none');
            } else {
                $(this).siblings('label').find('.field-description').removeClass('d-none');
                $(this).siblings('label').find('.field-description.default-level-description').addClass('d-none');
            }
        })
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <span><?= __('admin.award_level_module_is_off') ?></span>
                <a href="<?= base_url('admincontrol/addons') ?>"><?= __('admin.admin_click_here_to_activate') ?></a>
            </div>
        </div>
    </div>  
<?php } ?>