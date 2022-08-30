import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ImputTextComponent } from './imput-text.component';

describe('ImputTextComponent', () => {
  let component: ImputTextComponent;
  let fixture: ComponentFixture<ImputTextComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ImputTextComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ImputTextComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
