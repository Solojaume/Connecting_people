import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';

@Component({
  selector: 'app-slider',
  templateUrl: './slider.component.html',
  styleUrls: ['./slider.component.scss']
})
export class SliderComponent implements OnInit {
 @Input() config:any;
 @Output() like = new EventEmitter<string>();
 @Output() dislike = new EventEmitter<string>();
 configIm:IImagenesComponentConfig={
  type:"slider-imagen",
  edad:25,
  username:"Pene",
  like_dislike_button:true
 }

  likeDislikeM(l_d:string){
    switch (l_d) {
      case "dilike":
        this.dislike.emit();
        break;
      case "like":
        this.like.emit();
        break;
      default:
        break;
    }
   
  }
  constructor() { }

  ngOnInit(): void {
  }

  ngOnChange(): void{
    
  }
}
