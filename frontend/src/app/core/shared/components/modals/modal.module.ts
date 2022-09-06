import { NgModule } from "@angular/core";
import { NgbdModalConfirm, NgbdModalConfirmAutofocus, NgbdModalFocus } from "./modals-focus";

@NgModule({
declarations:
[
    NgbdModalFocus,
    NgbdModalConfirm,
    NgbdModalConfirmAutofocus
],
exports:[NgbdModalFocus,
    NgbdModalConfirm,
    NgbdModalConfirmAutofocus]
})
export class ModalModule { }