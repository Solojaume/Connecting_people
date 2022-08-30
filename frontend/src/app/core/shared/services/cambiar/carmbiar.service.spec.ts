import { TestBed } from '@angular/core/testing';

import { CarmbiarService } from './carmbiar.service';

describe('CarmbiarService', () => {
  let service: CarmbiarService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CarmbiarService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
