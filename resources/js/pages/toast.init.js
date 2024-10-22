/**
 * Theme: Rizz - Bootstrap 5 Responsive Admin Dashboard
 * Author: Mannatthemes
 * Toast Js
 */
import { Toast } from "bootstrap";
 var toastElList = [].slice.call(document.querySelectorAll('.toast'))
 var toastList = toastElList.map(function (toastEl) {
     var toast = new Toast(toastEl, { autohide: false });
     toast.show();
 });

 var toastPlacement = document.getElementById("toastPlacement");
 if (toastPlacement) {
     document.getElementById("selectToastPlacement").addEventListener("change", function () {
         if (!toastPlacement.dataset.originalClass) {
             toastPlacement.dataset.originalClass = toastPlacement.className;
         }
         toastPlacement.className = toastPlacement.dataset.originalClass + " " + this.value;
     });
 }