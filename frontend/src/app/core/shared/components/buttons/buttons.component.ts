import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-buttons',
  templateUrl: './buttons.component.html',
  styleUrls: ['./buttons.component.scss']
})
export class ButtonsComponent {
 @Input () button!:{nombre:string, link:string, classCSS:string, type:string};
  constructor(private router:Router) {}

  
  
  redirectTo(){
    if (this.button.link!==" ") {
      this.router.navigateByUrl(this.button.link);
    }
  }

}
