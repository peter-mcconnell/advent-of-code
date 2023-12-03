#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

int main()
{
	FILE *file;
	char line[1024];
	file = fopen("input", "r");

	if (file == NULL)
	{
		printf("Error opening file!\n");
		exit(1);
	}

	int total = 0;
	while (fgets(line, sizeof(line), file))
	{
		int firstNumber, lastNumber = -1;
		size_t len = strlen(line);

		int i;
		for (i = 0; i < len; i++)
		{
			if (isdigit(line[i]))
			{
				firstNumber = line[i];
				break;
			}
		}

		for (int j = len; j >= i; j--)
		{
			if (isdigit(line[j]))
			{
				lastNumber = line[j];
				break;
			}
		}


		if (firstNumber == -1 || lastNumber == -1)
		{
			printf("No numbers found for line: %s\n", line);
		} else {
			int subtotal = lastNumber - '0' + ((firstNumber - '0') * 10);
			total += subtotal;
		}

	}
	printf("Total: %d\n", total);
	fclose(file);
	return 0;
}
