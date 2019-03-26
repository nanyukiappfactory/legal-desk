var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
/// <reference path="./../../../../../js/declarations/KASClientCore.d.ts" />
/// <reference path="./../../../../../js/declarations/KASClientUI.d.ts" />
var Announcement;
(function (Announcement) {
    var AnnouncementInputFormPage = /** @class */ (function (_super) {
        __extends(AnnouncementInputFormPage, _super);
        function AnnouncementInputFormPage() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        AnnouncementInputFormPage.prototype.init = function (title, rightButtonTitle, doneCallback) {
            this.navigationBar.title = title;
            if (rightButtonTitle != null) {
                var rightActionText = KASClient.UI.getLabel(rightButtonTitle, {
                    "font-weight": "500",
                    "font-size": KASClient.UI.getScaledFontSize("14px"),
                    "color": BLUE_COLOR
                });
                this.navigationBar.rightButtonTitle = rightActionText.outerHTML;
                this.navigationBar.rightButtonAction = function () {
                    if (doneCallback) {
                        doneCallback();
                    }
                }.bind(this);
            }
            this.moduleContainer.backgroundColor = "white";
            this.moduleContainer.addModuleWithFullWidth(this.getInputModule());
        };
        return AnnouncementInputFormPage;
    }(KASClient.UI.KASFormPage));
    Announcement.AnnouncementInputFormPage = AnnouncementInputFormPage;
})(Announcement || (Announcement = {}));
/// <reference path="./AnnouncementInputFormPage.ts" />
var Announcement;
(function (Announcement) {
    var AnnouncementCreateDetailsFormPage = /** @class */ (function (_super) {
        __extends(AnnouncementCreateDetailsFormPage, _super);
        function AnnouncementCreateDetailsFormPage(title, description, conversationName, conversationParticipantsCount, doneCallback) {
            var _this = _super.call(this) || this;
            _this.titleView = null;
            _this.descriptionView = null;
            _this.announcementTitle = "";
            _this.announcementDescription = "";
            _this.completeAttachmentsList = [];
            _this.imageAttachmentList = [];
            _this.documentAttachment = null;
            _this.audioAttachment = null;
            _this.imageWrapperDiv = null;
            _this.documentWrapperDiv = null;
            _this.audioWrapperDiv = null;
            _this.documentsModuleMainDiv = null;
            _this.currentDailogView = null;
            _this.albumViewHandler = null;
            _this.documentViewHandler = null;
            _this.audioViewHandler = null;
            _this.announcementTitle = title;
            _this.announcementDescription = description;
            var albumViewModel = new KASClient.UI.KASAlbumViewModel();
            albumViewModel.showRemoveButton = true;
            albumViewModel.hasStaticContent = false;
            albumViewModel.enableOnTap = false;
            _this.albumViewHandler = new KASClient.UI.KASAlbumViewHandler(albumViewModel);
            _this.albumViewHandler.removeImageFromAlbumCallback = function (i) { this.removeImageFromAlbumCallback(i); }.bind(_this);
            var mainText = KASClient.UI.getElement("div", {
                "font-weight": "600",
                "color": "#32485f",
                "font-size": KASClient.UI.getScaledFontSize("20px")
            });
            mainText.innerText = Announcement.AnnouncementManager.getLocalizedString("AnnouncementDetailsPageTitle");
            _this.bottomBar.elements = [_this.getBottomView()];
            _this.moduleContainer.addModuleWithFullWidth(_this.getImageModule());
            _super.prototype.init.call(_this, mainText.outerHTML, Announcement.AnnouncementManager.getLocalizedString("Done"), function () {
                if (this.titleView.getInputText() == "") {
                    this.currentDailogView = KASClient.UI.getAlertDailog(Announcement.AnnouncementManager.getLocalizedString("IncompleteDetailsAlertTitle"), Announcement.AnnouncementManager.getLocalizedString("IncompleteQuestionDetailsMessage"), Announcement.AnnouncementManager.getLocalizedString("OK"), function () {
                        this.clearDailogView();
                    }.bind(this), "", null);
                    this.addDailogView();
                    return;
                }
                if (doneCallback) {
                    if (this.documentAttachment) {
                        this.completeAttachmentsList.push(this.documentAttachment);
                    }
                    if (this.audioAttachment) {
                        this.completeAttachmentsList.push(this.audioAttachment);
                    }
                    if (this.imageAttachmentList && this.imageAttachmentList.length > 0) {
                        KASClient.App.generateBase64ThumbnailAsync(this.imageAttachmentList[0].localPath, function (thumbnail, error) {
                            if (error == null && thumbnail != null) {
                                this.imageAttachmentList[0].thumbnail = thumbnail;
                                this.imageAttachmentList[0].hasSetThumbnail = true;
                            }
                            this.completeAttachmentsList.push.apply(this.completeAttachmentsList, this.imageAttachmentList);
                            if (this.navigationBar.rightButtonElements[0].getAttribute("disabled")) {
                                return;
                            }
                            this.navigationBar.rightButtonElements[0].setAttribute("disabled", true);
                            this.navigationBar.rightButtonElements[0].style.opacity = "0.2";
                            doneCallback(this.titleView.getInputText(), this.descriptionView.getInputText(), this.completeAttachmentsList);
                        }.bind(this));
                    }
                    else {
                        if (this.navigationBar.rightButtonElements[0].getAttribute("disabled")) {
                            return;
                        }
                        this.navigationBar.rightButtonElements[0].setAttribute("disabled", true);
                        this.navigationBar.rightButtonElements[0].style.opacity = "0.2";
                        doneCallback(this.titleView.getInputText(), this.descriptionView.getInputText(), this.completeAttachmentsList);
                    }
                }
            }.bind(_this));
            _this.moduleContainer.addView(_this.getDocsAudioView());
            _this.navigationBar.subtitle = Announcement.AnnouncementManager.getLocalizedString("SubtitleOneOnOneFormat", conversationName);
            _this.navigationBar.backAction = function () {
                if (this.currentDailogView != null) {
                    KASClient.UI.removeElement(this.currentDailogView, document.body);
                    this.clearDailogView();
                    return;
                }
                var deleteButton = KASClient.UI.getElement("div", {
                    "color": LIGHT_RED_COLOR
                });
                deleteButton.innerText = Announcement.AnnouncementManager.getLocalizedString("QuestionDiscardConfirmationDailogDeleteButton");
                this.currentDailogView = KASClient.UI.getAlertDailog(Announcement.AnnouncementManager.getLocalizedString("AnnouncementDetailsPageTitle"), Announcement.AnnouncementManager.getLocalizedString("QuestionDiscardConfirmationDailogMessage"), deleteButton.outerHTML, function () {
                    this.clearDailogView();
                    Announcement.AnnouncementManager.getPageNavigator().goBack();
                }.bind(this), Announcement.AnnouncementManager.getLocalizedString("QuestionDiscardConfirmationDailogBackButton"), function () {
                    this.clearDailogView();
                }.bind(this));
                this.addDailogView();
            }.bind(_this);
            return _this;
        }
        AnnouncementCreateDetailsFormPage.prototype.getDocsAudioView = function () {
            this.documentsModuleMainDiv = KASClient.UI.getElement("div", { "width": "100%", "height": "100px", "display": "none" });
            this.documentWrapperDiv = KASClient.UI.getElement("div", { "width": "50%", "height": "100%", "display": "none", "position": "relative", "float": "left" });
            this.documentWrapperDiv.id = "docDiv";
            KASClient.UI.addElement(this.documentWrapperDiv, this.documentsModuleMainDiv);
            this.audioWrapperDiv = KASClient.UI.getElement("div", { "width": "50%", "height": "100%", "display": "none", "position": "relative", "float": "left" });
            this.audioWrapperDiv.id = "audioDiv";
            KASClient.UI.addElement(this.audioWrapperDiv, this.documentsModuleMainDiv);
            var documentViewModel = new KASClient.UI.KASDocumentViewModel();
            documentViewModel.showRemoveButton = true;
            documentViewModel.enableOnTap = false;
            this.documentViewHandler = new KASClient.UI.KASDocumentViewHandler(documentViewModel);
            var audioViewModel = new KASClient.UI.KASAudioViewModel();
            audioViewModel.showRemoveButton = true;
            audioViewModel.enableOnTap = false;
            this.audioViewHandler = new KASClient.UI.KASAudioViewHandler(audioViewModel);
            return this.documentsModuleMainDiv;
        };
        AnnouncementCreateDetailsFormPage.prototype.clearDailogView = function () {
            Announcement.AnnouncementManager.setPageNavigatorAccessibilityHidden(false);
            this.currentDailogView = null;
        };
        AnnouncementCreateDetailsFormPage.prototype.addDailogView = function () {
            Announcement.AnnouncementManager.setPageNavigatorAccessibilityHidden(true);
            KASClient.UI.addElement(this.currentDailogView, document.body);
        };
        AnnouncementCreateDetailsFormPage.prototype.getImageModule = function () {
            var imageInputModule = new KASClient.UI.KASFormModule();
            this.imageWrapperDiv = KASClient.UI.getElement("div", { "width": "100%", "height": "224px", "display": "none" });
            KASClient.UI.addElement(this.albumViewHandler.getAlbumView(), this.imageWrapperDiv);
            imageInputModule.contentView = this.imageWrapperDiv;
            return imageInputModule;
        };
        AnnouncementCreateDetailsFormPage.prototype.getInputModule = function () {
            var titleDescriptionInputModule = new KASClient.UI.KASFormModule();
            var titleDescriptionViewAttribute = {
                "display": "flex",
                "margin": "15px",
                "flex-direction": "column",
            };
            var titleDescriptionView = KASClient.UI.getElement("div", titleDescriptionViewAttribute);
            var inputViewTitleAttributes = {
                "color": "#000000",
                "font-size": KASClient.UI.getScaledFontSize("12px"),
                "font-weight": "500"
            };
            this.titleView = new KASClient.UI.KASTextInputView(Announcement.AnnouncementManager.getLocalizedString("AnnouncementDetailsTitleHeader"), this.announcementTitle, Announcement.AnnouncementManager.getLocalizedString("AnnouncementDetailsTitlePlaceholder"), 20, inputViewTitleAttributes);
            this.titleView.setMaxLength(100);
            var titleActualView = this.titleView.getView();
            KASClient.UI.addElement(titleActualView, titleDescriptionView);
            KASClient.Customise.register(titleActualView, JSON.parse(JSON.stringify([
                {
                    "type": "Text",
                    "config": "AnnouncementDetailsTitleHeader",
                    "context": "textboxTitle"
                },
                {
                    "type": "Text",
                    "config": "AnnouncementDetailsTitlePlaceholder",
                    "context": "hintText"
                }
            ])));
            KASClient.App.isTalkBackEnabledAsync(function (talkBackEnabled) {
                if (!talkBackEnabled) {
                    setTimeout(function () {
                        this.titleView.setFocus(true);
                    }.bind(this), 100);
                }
            }.bind(this));
            this.descriptionView = new KASClient.UI.KASTextInputView(Announcement.AnnouncementManager.getLocalizedString("AnnouncementDetailsDescriptionHeader"), this.announcementDescription, Announcement.AnnouncementManager.getLocalizedString("AnnouncementDetailsDescriptionPlaceholder"), 16, inputViewTitleAttributes);
            this.descriptionView.setMaxLength(4000);
            var descriptionActualView = this.descriptionView.getView();
            KASClient.UI.addElement(descriptionActualView, titleDescriptionView);
            KASClient.Customise.register(descriptionActualView, JSON.parse(JSON.stringify([
                {
                    "type": "Text",
                    "config": "AnnouncementDetailsDescriptionHeader",
                    "context": "textboxTitle"
                },
                {
                    "type": "Text",
                    "config": "AnnouncementDetailsDescriptionPlaceholder",
                    "context": "hintText"
                }
            ])));
            titleDescriptionInputModule.contentView = titleDescriptionView;
            return titleDescriptionInputModule;
        };
        AnnouncementCreateDetailsFormPage.prototype.getBottomView = function () {
            var attachmentsToShow = [];
            if (Announcement.AnnouncementManager.getSetting("showImages", true)) {
                attachmentsToShow.push(KASClient.KASAttachmentType.Image);
            }
            if (Announcement.AnnouncementManager.getSetting("showDocuments", true)) {
                attachmentsToShow.push(KASClient.KASAttachmentType.Document);
            }
            if (Announcement.AnnouncementManager.getSetting("showAudio", true)) {
                attachmentsToShow.push(KASClient.KASAttachmentType.Audio);
            }
            if (attachmentsToShow == null || attachmentsToShow.length == 0) {
                return null;
            }
            else {
                var bottomView = KASClient.UI.getElement("div", {
                    "width": "100%",
                    "display": "flex",
                    "justify-content": "space-between",
                    "border-top": "#DFDFDF 1px solid"
                });
                bottomView.addEventListener("click", function () {
                    KASClient.App.showAttachmentPickerAsync(attachmentsToShow, null, function (selectedAttachments, error) {
                        if (error != null) {
                            return;
                        }
                        if (selectedAttachments && selectedAttachments.length > 0) {
                            for (var i = 0; i < selectedAttachments.length; i++) {
                                if (selectedAttachments[i].type == KASClient.KASAttachmentType.Image) {
                                    this.imageAttachmentList.push(selectedAttachments[i]);
                                }
                                else if (selectedAttachments[i].type == KASClient.KASAttachmentType.Document) {
                                    this.documentAttachment = selectedAttachments[i];
                                }
                                else if (selectedAttachments[i].type == KASClient.KASAttachmentType.Audio) {
                                    this.audioAttachment = selectedAttachments[i];
                                }
                            }
                            switch (selectedAttachments[0].type) {
                                case KASClient.KASAttachmentType.Image:
                                    this.refreshAlbumView();
                                    break;
                                case KASClient.KASAttachmentType.Audio:
                                    this.refreshAudioView();
                                    break;
                                case KASClient.KASAttachmentType.Document:
                                    this.refreshDocumentView();
                                    break;
                                default:
                                    break;
                            }
                        }
                    }.bind(this));
                }.bind(this));
                var textDiv = KASClient.UI.getLabel("", {
                    "color": "#006FF1",
                    "font-weight": "500",
                    "font-size": KASClient.UI.getScaledFontSize("16px"),
                    "width": "50%",
                    "display": "flex",
                    "margin-left": "20",
                    "align-items": "center"
                });
                textDiv.innerText = Announcement.AnnouncementManager.getLocalizedString("AttachmentPickerText");
                KASClient.UI.addElement(textDiv, bottomView);
                KASClient.Customise.register(bottomView, JSON.parse(JSON.stringify([
                    {
                        "type": "Text",
                        "config": "AttachmentPickerText",
                        "context": "TextLabelAttachmentPicker"
                    },
                    {
                        "type": "Boolean",
                        "config": "showImages",
                        "context": "AllowImageAttachments"
                    },
                    {
                        "type": "Boolean",
                        "config": "showDocuments",
                        "context": "AllowDocumentAttachments"
                    },
                    {
                        "type": "Boolean",
                        "config": "showAudio",
                        "context": "AllowAudioattachments"
                    }
                ])));
                var iconsDiv = KASClient.UI.getElement("div", {
                    "margin-right": "8"
                });
                if (Announcement.AnnouncementManager.getSetting("showImages", true)) {
                    var photoImage = KASClient.UI.getImage("./add_from_gallery.png", {
                        "object-fit": "contain",
                        "width": "25",
                        "margin": "8"
                    });
                    KASClient.UI.addElement(photoImage, iconsDiv);
                    KASClient.UI.setAccessibilityBasic(photoImage, true);
                }
                if (Announcement.AnnouncementManager.getSetting("showAudio", true)) {
                    var audioImage = KASClient.UI.getImage("./audio_attach.png", {
                        "object-fit": "contain",
                        "width": "25",
                        "margin": "8"
                    });
                    KASClient.UI.addElement(audioImage, iconsDiv);
                    KASClient.UI.setAccessibilityBasic(audioImage, true);
                }
                if (Announcement.AnnouncementManager.getSetting("showDocuments", true)) {
                    var documentImage = KASClient.UI.getImage("./document_attach.png", {
                        "object-fit": "contain",
                        "width": "25",
                        "margin": "8"
                    });
                    KASClient.UI.addElement(documentImage, iconsDiv);
                    KASClient.UI.setAccessibilityBasic(documentImage, true);
                }
                KASClient.UI.setAccessibilityBasic(iconsDiv, true);
                KASClient.UI.addElement(iconsDiv, bottomView);
                KASClient.UI.setAccessibilityBasic(bottomView, false, KASClient.UI.KASFormAccessibilityRole.Button, textDiv.innerText);
                return bottomView;
            }
        };
        AnnouncementCreateDetailsFormPage.prototype.refreshAlbumView = function () {
            if (this.imageAttachmentList) {
                if (this.imageWrapperDiv.style.display == "none") {
                    this.imageWrapperDiv.style.display = "block";
                    this.imageWrapperDiv.style.height = "200px";
                }
                this.albumViewHandler.model.imageObjects = this.imageAttachmentList;
                this.albumViewHandler.model.enableOnTap = false;
                this.albumViewHandler.refreshAlbumView();
            }
            else {
                this.imageWrapperDiv.style.display = "none";
                this.imageWrapperDiv.style.height = "0px";
            }
            this.imageWrapperDiv.scrollIntoView();
        };
        AnnouncementCreateDetailsFormPage.prototype.refreshDocumentView = function () {
            if (this.documentAttachment) {
                this.documentViewHandler.model.documentObj = this.documentAttachment;
                this.documentViewHandler.documentRemovedCallback = function () { this.removeDocumentCallback(); }.bind(this);
                var documentControl = this.documentViewHandler.getDocumentView();
                documentControl.style.padding = "12px";
                KASClient.UI.addElement(documentControl, this.documentWrapperDiv);
                if (this.documentWrapperDiv.style.display == "none") {
                    this.documentWrapperDiv.style.display = "block";
                    this.documentWrapperDiv.style.width = "50%";
                }
                if (this.documentsModuleMainDiv.style.display == "none") {
                    this.showDocumentsModuleDiv(true);
                }
                this.documentWrapperDiv.scrollIntoView();
            }
        };
        AnnouncementCreateDetailsFormPage.prototype.refreshAudioView = function () {
            if (this.audioAttachment) {
                this.audioViewHandler.model.audioObj = this.audioAttachment;
                this.audioViewHandler.audioRemovedCallback = function () { this.removeAudioCallback(); }.bind(this);
                var audioControl = this.audioViewHandler.getAudioView();
                audioControl.style.padding = "12px";
                KASClient.UI.addElement(audioControl, this.audioWrapperDiv);
                if (this.audioWrapperDiv.style.display == "none") {
                    this.audioWrapperDiv.style.display = "block";
                    this.audioWrapperDiv.style.width = "50%";
                }
                if (this.documentsModuleMainDiv.style.display == "none") {
                    this.showDocumentsModuleDiv(true);
                }
                this.audioWrapperDiv.scrollIntoView();
            }
        };
        AnnouncementCreateDetailsFormPage.prototype.removeImageFromAlbumCallback = function (index) {
            this.imageAttachmentList.splice(index, 1);
            if (this.imageAttachmentList.length == 0) {
                this.imageWrapperDiv.style.display = "none";
                this.imageWrapperDiv.style.height = "0px";
            }
        };
        AnnouncementCreateDetailsFormPage.prototype.removeDocumentCallback = function (index) {
            this.documentAttachment = null;
            this.documentWrapperDiv.style.display = "none";
            this.documentWrapperDiv.style.width = "0px";
            if (this.audioWrapperDiv.style.display == "none") {
                this.showDocumentsModuleDiv(false);
                ;
            }
        };
        AnnouncementCreateDetailsFormPage.prototype.removeAudioCallback = function (index) {
            this.audioAttachment = null;
            this.audioWrapperDiv.style.display = "none";
            this.audioWrapperDiv.style.width = "0px";
            if (this.documentWrapperDiv.style.display == "none") {
                this.showDocumentsModuleDiv(false);
            }
        };
        AnnouncementCreateDetailsFormPage.prototype.showDocumentsModuleDiv = function (show) {
            if (show) {
                this.documentsModuleMainDiv.style.display = "block";
                this.documentsModuleMainDiv.style.height = "100px";
            }
            else {
                this.documentsModuleMainDiv.style.display = "none";
                this.documentsModuleMainDiv.style.height = "0px";
            }
        };
        return AnnouncementCreateDetailsFormPage;
    }(Announcement.AnnouncementInputFormPage));
    Announcement.AnnouncementCreateDetailsFormPage = AnnouncementCreateDetailsFormPage;
})(Announcement || (Announcement = {}));
var Announcement;
(function (Announcement) {
    var AnnouncementManager = /** @class */ (function () {
        function AnnouncementManager(pageNavigatorElement) {
            AnnouncementManager.pageNavigator = new KASClient.UI.KASFormPageNavigator();
            KASClient.UI.addElement(AnnouncementManager.pageNavigator.getView(), pageNavigatorElement);
        }
        AnnouncementManager.getLocalizedString = function (id) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            return (_a = KASClient.App).printf.apply(_a, [this.strings[id]].concat(args));
            var _a;
        };
        AnnouncementManager.getPageNavigator = function () {
            return this.pageNavigator;
        };
        AnnouncementManager.getSetting = function (settingName, optValue) {
            if (AnnouncementManager.settings && AnnouncementManager.settings.hasOwnProperty(settingName)) {
                return AnnouncementManager.settings[settingName];
            }
            return optValue;
        };
        AnnouncementManager.prototype.initialize = function (finishCallback) {
            KASClient.App.getPackageCustomSettingsAsync(function (settings, error) {
                if (error != null) {
                    return;
                }
                AnnouncementManager.settings = settings;
                KASClient.App.getLocalizedStringsAsync(function (strings, error) {
                    if (error != null) {
                        return;
                    }
                    AnnouncementManager.strings = strings;
                    document.title = AnnouncementManager.strings["AnnouncementCreationPageTitle"];
                    KASClient.App.getConversationParticipantsCountAsync(function (count, error) {
                        if (error != null) {
                            return;
                        }
                        AnnouncementManager.conversationParticipantsCount = count;
                        KASClient.App.getConversationNameAsync(function (name, error) {
                            if (error != null) {
                                return;
                            }
                            AnnouncementManager.conversationName = name;
                            KASClient.Form.initFormAsync(function (form, error) {
                                if (error != null) {
                                    AnnouncementManager.survey = new KASClient.KASForm();
                                }
                                else {
                                    AnnouncementManager.survey = form;
                                }
                                finishCallback();
                            });
                        });
                    });
                });
            });
        };
        AnnouncementManager.prototype.inflateView = function () {
            var surveyPreviewPage = new Announcement.AnnouncementCreateDetailsFormPage("", "", AnnouncementManager.conversationName, AnnouncementManager.conversationParticipantsCount, function (title, description, attachmentList) {
                AnnouncementManager.survey.title = title;
                var properties = AnnouncementManager.survey.properties;
                if (description != "") {
                    var descriptionProperty = new KASClient.KASFormProperty();
                    descriptionProperty.name = "Description";
                    descriptionProperty.type = KASClient.KASFormPropertyType.Text;
                    descriptionProperty.value = description;
                    properties[properties.length] = descriptionProperty;
                }
                if (attachmentList != null && attachmentList.length > 0) {
                    properties.push(KASClient.KASFormPropertyFactory.getAttachmentListProperty(attachmentList, "loa"));
                }
                KASClient.createRequest(AnnouncementManager.survey.toJSON());
            });
            AnnouncementManager.getPageNavigator().pushPage(surveyPreviewPage);
        };
        AnnouncementManager.setPageNavigatorAccessibilityHidden = function (hidden) {
            var pageNavigator = document.getElementById("pageNavigator");
            KASClient.UI.setAccessibilityAttribute(pageNavigator, KASClient.UI.KASFormAccessibilityKey.Hidden, hidden);
            KASClient.Internal.screenChanged("");
        };
        AnnouncementManager.settings = null;
        AnnouncementManager.strings = null;
        AnnouncementManager.survey = null;
        AnnouncementManager.conversationParticipantsCount = 0;
        AnnouncementManager.conversationName = null;
        return AnnouncementManager;
    }());
    Announcement.AnnouncementManager = AnnouncementManager;
})(Announcement || (Announcement = {}));
