import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewImageUploaderComponent } from './new-image-uploader.component';

describe('NewImageUploaderComponent', () => {
  let component: NewImageUploaderComponent;
  let fixture: ComponentFixture<NewImageUploaderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NewImageUploaderComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(NewImageUploaderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
