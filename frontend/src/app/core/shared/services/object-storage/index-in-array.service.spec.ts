import { TestBed } from '@angular/core/testing';

import { IndexInArrayService } from './index-in-array.service';

describe('IndexInArrayService', () => {
  let service: IndexInArrayService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(IndexInArrayService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
