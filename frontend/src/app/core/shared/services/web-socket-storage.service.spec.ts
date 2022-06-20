import { TestBed } from '@angular/core/testing';

import { WebSocketStorageService } from './web-socket-storage.service';

describe('WebSocketStorageService', () => {
  let service: WebSocketStorageService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WebSocketStorageService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
