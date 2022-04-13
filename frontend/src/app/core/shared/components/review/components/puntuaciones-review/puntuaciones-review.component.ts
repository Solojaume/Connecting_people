import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-puntuaciones-review',
  templateUrl: './puntuaciones-review.component.html',
  styleUrls: ['./puntuaciones-review.component.scss']
})
export class PuntuacionesReviewComponent implements OnInit {
  @Input() puntuaciones:any;
  
  constructor() { }

  ngOnInit(): void {
  }

}
