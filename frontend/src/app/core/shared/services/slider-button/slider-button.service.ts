import { EventEmitter, Injectable } from '@angular/core';
import {
  BreakpointObserver,
  Breakpoints,
  BreakpointState,
} from '@angular/cdk/layout';

@Injectable({
  providedIn: 'root',
})
export class SliderButtonService {
  public event_reviews_estan_cargadas: EventEmitter<boolean> =
    new EventEmitter<boolean>();
  public event_reviews_visibles: EventEmitter<boolean> =
    new EventEmitter<boolean>();
  public reviews_estan_cargadas: boolean = false;
  public reviews_visibles: boolean = false;
  public sizeDisplay: string = 'phone' || 'web';

  constructor(public breakpointObserver: BreakpointObserver) {
    
  }

  set_reviews_estan_cargadas(bool: boolean) {
    this.reviews_estan_cargadas = bool;
    this.event_reviews_estan_cargadas.emit(bool);
  }

  set_reviews_visibles(bool: boolean) {
    this.reviews_estan_cargadas = bool;
    this.event_reviews_visibles.emit(bool);
  }
  
}
