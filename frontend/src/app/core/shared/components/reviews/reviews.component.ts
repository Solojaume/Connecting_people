import {
  BreakpointObserver,
  Breakpoints,
  BreakpointState,
} from '@angular/cdk/layout';
import { Component, Input, OnInit } from '@angular/core';
import { SliderButtonService } from '../../services/slider-button/slider-button.service';

@Component({
  selector: 'app-reviews',
  templateUrl: './reviews.component.html',
  styleUrls: ['./reviews.component.scss'],
})
export class ReviewsComponent implements OnInit {
  @Input() reviews!: any;
  constructor(
    public breakpointObserver: BreakpointObserver,
    public reviewsButtonsService: SliderButtonService
  ) {}
  public sizeDisplay: string = 'phone' || 'web';

  ngOnInit(): void {
    console.log('Reviews:', this.reviews);
    this.mediaQuery();
  }
  public mediaQuery() {
    this.breakpointObserver
      .observe(Breakpoints.Small)
      .subscribe((state: BreakpointState) => {
        if (state.matches) {
          //alert('small');
          //AQUI SERA TRUE SOLO SI ESTA EN RESOLUCION DE CELULAR
          this.sizeDisplay = 'phone';
          this.reviewsButtonsService.event_reviews_visibles.emit(false);
        }
      });
      
      this.breakpointObserver
      .observe(Breakpoints.Medium)
      .subscribe((state: BreakpointState) => {
        if (state.matches) {
          //alert('medium');
          //AQUI SERA TRUE SOLO SI ESTA EN RESOLUCION DE CELULAR
          this.sizeDisplay = 'web';
          this.reviewsButtonsService.event_reviews_visibles.emit(false);
        }
      });
    this.breakpointObserver
      .observe(Breakpoints.Web)
      .subscribe((state: BreakpointState) => {
        if (state.matches) {
          //alert('web');
          //AQUI SERA TRUE SOLO SI ES RESOLUCION PARA WEB
          this.sizeDisplay = 'web';
          this.reviewsButtonsService.event_reviews_visibles.emit(true);
        }
      });
    
    this.breakpointObserver
      .observe(Breakpoints.Large)
      .subscribe((state: BreakpointState) => {
        if (state.matches) {
          //alert('large');
          //AQUI SERA TRUE SOLO SI ESTA EN RESOLUCION DE desktop
          this.sizeDisplay = 'web';
          this.reviewsButtonsService.event_reviews_visibles.emit(true);
        }
      });
    this.breakpointObserver
      .observe(Breakpoints.XLarge)
      .subscribe((state: BreakpointState) => {
        if (state.matches) {
          //alert('xlarge');
          //AQUI SERA TRUE SOLO SI ESTA EN RESOLUCION DE CELULAR
          this.sizeDisplay = 'web';
        }
      });
  }
}
