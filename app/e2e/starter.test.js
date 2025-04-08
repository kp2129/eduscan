describe('Login Flow', () => {
  beforeAll(async () => {
    await device.launchApp({ newInstance: true });
  });

  beforeEach(async () => {
    await device.launchApp({ newInstance: true });
  });

  it('should display the login screen', async () => {
    await expect(element(by.id('login_screen'))).toBeVisible();
  });

  it('should allow user to input email and password', async () => {
    await element(by.id('email_input')).typeText('test@example.com');
    await element(by.id('password_input')).typeText('password123');
    
    const emailValue = await element(by.id('email_input')).getAttributes();
    const passwordValue = await element(by.id('password_input')).getAttributes();

    expect(emailValue.text).toBe('test@example.com');
    expect(passwordValue.text).toBe('password123');
  });

  it('should show error message for invalid login', async () => {
    await element(by.id('email_input')).typeText('invalid@example.com');
    await element(by.id('password_input')).typeText('wrongpassword');
    await element(by.id('login_button')).tap();
    
    await expect(element(by.text('Login Error'))).toBeVisible();
    await expect(element(by.text('An error occurred during login.'))).toBeVisible();
  });

  it('should navigate to home after successful login', async () => {
    await element(by.id('email_input')).typeText('test@example.com');
    await element(by.id('password_input')).typeText('password123');
    await element(by.id('login_button')).tap();
    
    await expect(element(by.id('home_screen'))).toBeVisible();
  });
});
