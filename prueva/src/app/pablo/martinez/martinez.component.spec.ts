import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MartinezComponent } from './martinez.component';

describe('MartinezComponent', () => {
  let component: MartinezComponent;
  let fixture: ComponentFixture<MartinezComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MartinezComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MartinezComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
