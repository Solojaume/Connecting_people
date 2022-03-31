import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PruevaComponent } from './prueva.component';

describe('PruevaComponent', () => {
  let component: PruevaComponent;
  let fixture: ComponentFixture<PruevaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PruevaComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PruevaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
