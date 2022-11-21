import { TestBed } from '@angular/core/testing';

import { AspectoService } from './aspecto.service';

describe('AspectoService', () => {
  let service: AspectoService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AspectoService);
  });
    
  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
