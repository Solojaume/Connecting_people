import { TestBed } from '@angular/core/testing';

import { SliderButtonService } from './slider-button.service';

describe('SliderButtonService', () => {
  let service: SliderButtonService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(SliderButtonService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
