import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-buttons',
  templateUrl: './buttons.component.html',
  styleUrls: ['./buttons.component.scss']
})
export class ButtonsComponent  implements OnInit {
  @Input () type!:string;
  @Input () nombre!:string;
  @Input () class!:any;
  @Input () routerLink!:any;

  constructor() {
    
   }

  ngOnInit(): void {
    if(this.class==null  ){
      this.class="btn-border-primary";
    }

    
  }

}
