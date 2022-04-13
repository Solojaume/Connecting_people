import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-stars',
  templateUrl: './stars.component.html',
  styleUrls: ['./stars.component.scss']
})
export class StarsComponent implements OnInit {
//Inputs
  @Input () puntuacion:any;
  @Input () max:any;

  //Declaraciones de variables
  resto!:number;
  constructor() { }

  ngOnInit(): void {
    this.resto=this.max-this.puntuacion;
    if (this.resto<0) {
      this.resto=0;
    }

  }

  condicion(n:number){
    if(this.max>n && this.puntuacion<=n){
      return true;
    }
    return false;
  }

  counter(e:number){
    //console.log(e);
    var a =[];
    for (let index = 0; index <e; index++) {
      a.push(index);
      
    }
    return a;
  } 

  col(max_stars:number){
    
  }
}
