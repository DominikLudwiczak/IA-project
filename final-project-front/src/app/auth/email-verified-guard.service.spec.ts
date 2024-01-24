import { TestBed } from '@angular/core/testing';

import { EmailVerifiedGuardService } from './email-verified-guard.service';

describe('EmailVerifiedGuardService', () => {
  let service: EmailVerifiedGuardService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(EmailVerifiedGuardService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
