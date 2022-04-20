import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
@Component({
  selector: 'app-redirectable-button',
  templateUrl: './redirectable-button.component.html',
  styleUrls: ['./redirectable-button.component.scss']
})
export class RedirectableButtonComponent implements OnInit  {
  //Propiedades internas del componente
  @Input () nombre!:string;
  @Input () link!:string;
  type!:string;
  @Input () class!:any;
  //@Input () data!:any[];//data=[["clave",valor],["clave", valor]]
  constructor(private router:Router) { }

  ngOnInit(): void {
    this.type="button";
    /*if (this.data.length>0) {
      this.class=this.data[0][1];
      this.nombre = this.data[1][1];
      this.link = this.data[2][1];
      switch (this.data.length) {
        case 3:
          
          break;
      
        default:
          break;
      }
    }*/
  }

  clink(){
    this.router.navigateByUrl(this.link);
  }

  

}
