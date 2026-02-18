<form action="#" id="frmGeneratePassword" class="form-horizontal">
    <div class="modal" id="modalGeneratePassword">
        <div class="modal-dialog special">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        {$LANG.generatePassword.title}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger hidden" id="generatePwLengthError">
                        {$LANG.generatePassword.lengthValidationError}
                    </div>
                    <div class="form-group">
                        <label for="generatePwLength" class="col-sm-4 control-label">{$LANG.generatePassword.pwLength}</label>
                        <div class="col-sm-8">
                            <input type="number" min="8" max="64" value="12" step="1" class="form-control input-inline input-inline-100" id="inputGeneratePasswordLength">
                        </div>
                    </div>
                    
                    
                   <!-- Assume the checkboxes are added within the modal body -->
                    

        
        
                    <div class="form-group">
                        <label for="generatePwOutput" class="col-sm-4 control-label">{$LANG.generatePassword.generatedPw}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputGeneratePasswordOutput">
                        </div>
                    </div>
                    
                    
                    <!-- Assume the checkboxes are added within the modal body -->
                    <div class="form-group">
                        
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-md-6" style="margin-left: 0 !important;">
                                    <h3 style="font-size: 14px !important; font-weight: 500; margin-bottom: 0;">Alpha Characters</h3>
                                    <label class="checkbox-inline" style="margin-left: 0 !important;">
                                        <input type="checkbox" id="mixedCaseAlphaCheckbox"> Both(aBcD)
                                    </label>
                                    <label class="checkbox-inline" style="margin-left: 0 !important;">
                                        <input type="checkbox" id="mixedCaseSpecialCharsCheckbox"> Both(1@3$)
                                    </label>
                                    <label class="checkbox-inline" style="margin-left: 0 !important;">
                                        <input type="checkbox" id="uppercaseCheckbox"> Uppercase(ABC)
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="font-size: 14px !important; font-weight: 500; margin-bottom: 0;">Non-Alpha Characters</h3>
                                    <label class="checkbox-inline" style="margin-left: 0 !important;">
                                        <input type="checkbox" id="numbersCheckbox"> Numbers(123)
                                    </label>
                                    <label class="checkbox-inline" style="margin-left: 0 !important;">
                                        <input type="checkbox" id="lowercaseCheckbox"> Lowercase(abc)
                                    </label>
                                    <label class="checkbox-inline" style="margin-left: 0 !important;">
                                        <input type="checkbox" id="symbolsCheckbox"> Symbols(@#$)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-check-all custom-button btn-sm">
                                <i class="fas fa-plus fa-fw"></i>
                                {$LANG.generatePassword.generateNew}
                            </button>
                           
                        </div>
                        
                        <label class="checkbox-inline" style="margin-left: 20px;">
                        <input type="checkbox" id="copiedPasswordCheckbox"> I have copied this password in a safe place.
                    </label>
                    
                    
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn outline-btn" data-dismiss="modal">
                        {$LANG.close}
                    </button>
                    <button type="button" class="btn primary-solid-btn" id="btnGeneratePasswordInsert" data-clipboard-target="#inputGeneratePasswordOutput" disabled>
                        {$LANG.generatePassword.copyAndInsert}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>



