import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-review',
  templateUrl: './review.component.html',
  styleUrls: ['./review.component.scss']
})
export class ReviewComponent implements OnInit {
  @Input () datos:any;

  //Variables 
  ver_mas!:boolean;
  ver_menos!:boolean;
  constructor() { }
  menos():void{
    this.ver_mas=false;
    this.ver_menos=true;
  }
  mas():void{
    this.ver_mas=true;
    this.ver_menos=false;
  }
  
  
  ngOnInit(): void {
    console.log("Review:",this.datos);
    this.ver_mas=true;
    this.ver_menos=false;
  }

}
