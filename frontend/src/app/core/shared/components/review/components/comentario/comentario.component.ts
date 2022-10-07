import { StringMap } from '@angular/compiler/src/compiler_facade_interface';
import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-comentario',
  templateUrl: './comentario.component.html',
  styleUrls: ['./comentario.component.scss']
})
export class ComentarioComponent  {
  @Input () comentario!:String;
  constructor() { }


}
