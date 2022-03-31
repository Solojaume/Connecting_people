import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PruevaC1Component } from './prueva-c1.component';

describe('PruevaC1Component', () => {
  let component: PruevaC1Component;
  let fixture: ComponentFixture<PruevaC1Component>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PruevaC1Component ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PruevaC1Component);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
