/*
 Copyright (c) 2014, Pixel & Tonic, Inc.
 @license   http://craftcms.com/license Craft License Agreement
 @see       http://craftcms.com
 @package   craft.app.resources
*/
(function(a){Craft.AccountSettingsForm=Garnish.Base.extend({userId:null,isCurrent:null,$copyPasswordResetUrlBtn:null,$actionSpinner:null,confirmDeleteModal:null,$deleteBtn:null,init:function(c,b){this.userId=c;this.isCurrent=b;this.$copyPasswordResetUrlBtn=a("#copy-passwordreset-url");this.$actionSpinner=a("#action-spinner");this.$deleteBtn=a("#delete-btn");this.addListener(this.$copyPasswordResetUrlBtn,"click","handleCopyPasswordResetUrlBtnClick");this.addListener(this.$deleteBtn,"click","showConfirmDeleteModal")},
handleCopyPasswordResetUrlBtnClick:function(){Craft.elevatedSessionManager.requireElevatedSession(a.proxy(this,"getPasswordResetUrl"))},getPasswordResetUrl:function(){this.$actionSpinner.removeClass("hidden");Craft.postActionRequest("users/getPasswordResetUrl",{userId:this.userId},a.proxy(function(a,b){this.$actionSpinner.addClass("hidden");if("success"==b){var d=Craft.t("{ctrl}C to copy.",{ctrl:navigator.appVersion.indexOf("Mac")?"\u2318":"Ctrl-"});prompt(d,a)}},this))},showConfirmDeleteModal:function(){this.confirmDeleteModal?
this.confirmDeleteModal.show():this.confirmDeleteModal=new Craft.DeleteUserModal(this.userId)}})})(jQuery);

//# sourceMappingURL=AccountSettingsForm.min.map
