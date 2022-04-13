import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PuntuacionesReviewComponent } from './puntuaciones-review.component';

describe('PuntuacionesReviewComponent', () => {
  let component: PuntuacionesReviewComponent;
  let fixture: ComponentFixture<PuntuacionesReviewComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PuntuacionesReviewComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PuntuacionesReviewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
