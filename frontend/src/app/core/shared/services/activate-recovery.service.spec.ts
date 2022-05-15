import { TestBed } from '@angular/core/testing';

import { ActivateRecoveryService } from './activate-recovery.service';

describe('ActivateRecoveryService', () => {
  let service: ActivateRecoveryService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ActivateRecoveryService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
