// --- ������������ ���������� ����
#include <windows.h>
#include <iostream>
using namespace std;

// --- �������� ������� �������� ����
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam);

// --- ���������� ����������
HINSTANCE hInst; 		// ���������� ���������� ����������
char ClassName[] = "Window"; 		// �������� ������ ����
char AppTitle[] = "Application Win32"; 	// ��������� �������� ����

HWND hTextBox;

// --- ������� WinMain
int WINAPI WinMain(HINSTANCE hInstance,
	// ���������� ���������� ����������
	HINSTANCE hPrevInstance, // � Win32 ������ ����� NULL
	LPSTR lpCmdLine,
	// ��������� �� ��������� ������. �� // ���������
	// ���������� �������� ������ �� ��������� ������.
	int nCmdShow
	// ����������, ��� ���������� ������������� 
	// ������������ �� �������: ������������
	// (nCmdShow = SW_SHOWMINNOACTIVE) 
	// ��� � ���� ��������� ���� 					//(nCmdShow = SW_SHOWNORMAL).
)
{
	WNDCLASS wc; 	// ��������� ��� ���������� � ������ ����
	HWND hWnd; 	// ���������� �������� ���� ����������
	HBRUSH greyBrush = CreateSolidBrush(RGB(220, 220, 220));
	MSG msg; 	// ��������� ��� �������� ���������
// ��������� ���������� ���������� ���������� � ����������
// ����������, ����� ��� ������������� ��������������� �� �
// ������� ����.
	hInst = hInstance;


	// --- ���������, ���� �� ���������� �������� �����.
	// ������������� �������� FindWindow, ������� ���������
	// ����� ���� �������� 
	// ������ �� ����� ������ ��� �� ��������� ����:
	// HWND FindWindow(LPCTSTR lpClassName,
	// LPCTSTRlpWindowName);
	// ����� �������� lpClassName ���������� ��������� ��
	// ��������� ������, � ������� ���������� �������� ���
	// ������ �������� ����. �� ���� ������ � ���� �� ������ 
	// ����� ������� ��������� ����. ���� ���������� ����� 
	// ���� � �������� ����������, �� ��� ��������� �������
	// �������� ����� �������� lpWindowName. ���� �� �������� 
	// ����� ����, �� �������� lpWindowName ����� �����
	// �������� NULL.
	if ((hWnd = FindWindow(ClassName, NULL)) != NULL)
	{
		// ������������ ����� �� �������, ����� ���������� ���
		// ��������, � ����� ���. ����� �� ��������� ����������, 
		// �� �������, ��� �� ������ �������� ��� ������� ����.
		// �������, ���� ���������� ���� �������� �����,
		// ������������� �������������� � ��������� �� ��������
		// ���� ��� ������� ����. ��� ������ ��, � ���� ������������
		// ������������.
		if (IsIconic(hWnd)) ShowWindow(hWnd, SW_RESTORE);
		SetForegroundWindow(hWnd);

		// ������� ���������� ����� - ������ ����� �����
		// ������������.
		return FALSE;
	}

	// --- ���������� ����� �� ������� - ������� WinMain
	// ���������� � �������������. ���������� ���������
	// WNDCLASS ��� ����������� ������ ����.
	memset(&wc, 0, sizeof(wc));
	wc.lpszClassName = ClassName;		// ��� ������ ����
	wc.lpfnWndProc = (WNDPROC)WndProc;
	// ����� ������� �������
	wc.style = CS_HREDRAW | CS_VREDRAW;	// ����� ������ 
	wc.hInstance = hInstance;		// ��������� ����������
	wc.hIcon = LoadIcon(NULL, IDI_APPLICATION);
	// ����������� ��� ����
	wc.hCursor = LoadCursor(NULL, IDC_ARROW);
	// ������ ���� ��� ����
	wc.hbrBackground = (HBRUSH)GetStockObject(WHITE_BRUSH);
	// ����� ��� ����
	wc.lpszMenuName = NULL;			// ������ ���� ����
	wc.cbClsExtra = 0;			// �������������� ������
	wc.cbWndExtra = 0;			// �������������� ������
	wc.hbrBackground = greyBrush;
	// P���������� ������ ����.
	RegisterClass(&wc);

	// ������� ������� ���� ����������.
	hWnd = CreateWindow(
		ClassName, 			// ��� ������ ����
		AppTitle,			// ��������� ���� 
		WS_OVERLAPPEDWINDOW, 		// ����� ����
		CW_USEDEFAULT,			// X-���������� 
		CW_USEDEFAULT,			// Y-���������� 
		CW_USEDEFAULT,			// ������ ����
		CW_USEDEFAULT,			// ������ ����
		NULL,			// ���������� ����-��������
		NULL,			// ���������� ���� ����
		hInst,		// ���������� ���������� ����������
		NULL);		// �������������� ����������
	if (!hWnd)
	{
		// ���� �� �������, ������ ��������������.
		MessageBox(NULL,
			"Create: error", AppTitle, MB_OK | MB_ICONSTOP);
		return FALSE;
	}

	// ���������� ����.
	ShowWindow(hWnd, nCmdShow);

	// ��������� ���������� ���������� ������� ����.
	UpdateWindow(hWnd);

	// ��������� ���� ��������� ������� ���������.
	// ������� GetMessage �������� ��������� �� �������, 
	// ������ false ��� ������� �� ������� ��������� WM_QUIT
	while (GetMessage(&msg, NULL, 0, 0))
	{
		// �������������� ��������� ���������, 
		// ���������� � ������� ����������
		TranslateMessage(&msg);
		// ���������� ��������� ������� ���������
		DispatchMessage(&msg);
	}

	return msg.wParam;
}

char str[MAX_PATH] = "";
// --- ������� ����
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam)
{
	
	//char* str = new char[100];
	string st="";

	switch (msg)
	{
	case WM_CREATE:
	{
		hTextBox = CreateWindow(TEXT("EDIT"), TEXT(""), WS_VISIBLE | WS_CHILD|ES_MULTILINE, 0, 50, 100, 100, hWnd, NULL, NULL, NULL,);
	};break;

	case WM_MOUSEMOVE:
	{
		// ��������� ������ ����
		UINT fwKeys = wParam;
		// �������������� ������� �������
		int xPos = LOWORD(lParam);
		// ������������ ������� �������
		int yPos = HIWORD(lParam);

		if (fwKeys & MK_LBUTTON)
		{
			HDC hDC = GetDC(hWnd);
			SetPixel(hDC, xPos, yPos, 0l);
			ReleaseDC(hWnd, hDC);
		}
	}; break;

		// ���������� �������� ���������� ���������� ������� ����.
	case WM_PAINT:
	{
		HDC hDC;
		PAINTSTRUCT ps;

		hDC = BeginPaint(hWnd, &ps);
		SetBkMode(hDC, TRANSPARENT);
		// �������� �������� ����
		TextOut(hDC, 20, 20, str, strlen(str));
		// ���������� �����
		EndPaint(hWnd, &ps);
		// ���������� �������� ����
	}; break;

	case WM_CHAR:
	{
		if(wParam==0x0D)
			str[strlen(str)] += '\n';
		else
		{
			str[strlen(str)] += wParam;
		}
		
		InvalidateRect(hWnd, NULL, TRUE);
	}
	break;


	// ������������ ������ ����.
	case WM_DESTROY:
	{
		// ���� ������ ������� �������� ������� ��������
		// �������� ����, �� ������� � ������� ���������
		// ���������� ������� ��������� WM_QUIT 
		PostQuitMessage(0);
	}; break;

	// �������������� ��������� �������� � �����������
	// ������� ��������� ��������� �� ���������.
	default: return DefWindowProc(hWnd, msg, wParam, lParam);
	}
	return 0l;
}
